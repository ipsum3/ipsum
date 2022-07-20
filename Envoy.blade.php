{{--
 Commande =>   envoy run deploy --env=prod

# .env

DEPLOY_USER=XXX
DEPLOY_SERVER=XXX.com
DEPLOY_BASE_DIR_PROD=/home/XXXX/site
DEPLOY_BASE_DIR_TEST=/home/XXXX/XXXXX/site
DEPLOY_PHP_VERSION=8.1
DEPLOY_DEPOT=ssh://XXX/XXX

# Exemple
https://adrien.poupa.net/zero-downtime-laravel-deployments-with-laravel-envoy/
--}}

@setup

    require __DIR__.'/vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    try {
        $dotenv->load();
        $dotenv->required(['DEPLOY_USER', 'DEPLOY_SERVER', 'DEPLOY_BASE_DIR_PROD', 'DEPLOY_PHP_VERSION', 'DEPLOY_DEPOT'])->notEmpty();
    } catch ( Exception $e )  {
        echo $e->getMessage();
        die();
    }

    $user = env('DEPLOY_USER');
    $depot = env('DEPLOY_DEPOT');

    $php_version = env('DEPLOY_PHP_VERSION');

    $dirlinks = ['storage', 'public/uploads'];
    $filelinks = ['.env'];

    $releases = 3;


    if ($env == null) {
        throw new Exception('--env  must be specified');
	} elseif ($env === 'prod') {
        $branche = 'master';
        $dir = env('DEPLOY_BASE_DIR_PROD');
    } else {
        $branche = $env;
        $dir = env('DEPLOY_BASE_DIR_'.strtoupper($env));
        if ($dir === null) {
            throw new Exception('env '.'DEPLOY_BASE_DIR_'.strtoupper($env).' must be specified');
        }
    }

    $shared = $dir . '/shared';
    $current = $dir . '/current';
    $release = $dir . "/releases/" . date('YmdHis');


    function logMessage($message) {
        return "echo '\033[32m" .$message. "\033[0m';\n";
    }

@endsetup

@servers(['web' => 'root@'.env('DEPLOY_SERVER')])

@story('deploy')
    createrelease
@endstory


@task('prepare')

    {{ logMessage("######## prepare ########") }}

    {{-- Gestion connexion ssh --}}
    mkdir -p /home/{{ $user }}/.ssh;
    chown {{ $user }}:{{ $user }} /home/{{ $user }}/.ssh;
    cp /root/.ssh/id_rsa /home/{{ $user }}/.ssh;
    chown  {{ $user }}:{{ $user }} /home/{{ $user }}/.ssh/id_rsa;
    cp /root/.ssh/known_hosts /home/{{ $user }}/.ssh;
    chown  {{ $user }}:{{ $user }} /home/{{ $user }}/.ssh/known_hosts;

    {{-- autre possibilité pour ajout known_hosts
    ssh -o StrictHostKeyChecking=no {{ $depot_remote }} --}}

    su - {{ $user }};

    {{-- Création des répertoires --}}
    mkdir -p {{ $shared }};

    cd {{ $dir }}

    {{-- installation de composer en local pour pallier au problème de version de php --}}
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php composer-setup.php
    php -r "unlink('composer-setup.php');"

@endtask


@task('createrelease')

    if [ ! -d {{ $shared }} ]; then
        {{ logMessage("Dossier ".$current." absent => envoy run prepare") }}
        exit 0;
    fi


    {{ logMessage("######## createrelease ########") }}

    su - {{ $user }};

    mkdir -p {{ $release }};

    git archive {{ $branche }} --remote {{ $depot }} | tar -x -C {{ $release }};


    {{ logMessage("######## composer install ########") }}


    mkdir -p {{ $shared }}/vendor;
    ln -s {{ $shared }}/vendor {{ $release }}/vendor;
    cd {{ $release }};
    php{{ $php_version }} {{ $dir }}/composer.phar install --no-dev --no-progress;




    {{ logMessage("######## Vérification .env ########") }}

    has_env=true;
    if [ ! -f {{ $shared }}/.env ]; then
        cp {{ $release }}/.env.example {{ $shared }}/.env
        {{ logMessage("Fichier .env à renseigner => envoy run init") }}
        has_env=false;
    fi
    {{--php -r "if (!file_exists('.env')) { copy('{{ $release }}/.env.example', '.env'); }"--}}



    {{ logMessage("######## links ########") }}

    @foreach($dirlinks as $link)

        @if ($link == 'storage')
            php -r "if (!file_exists('{{ $shared }}/storage')) {
                exec('mv {{ $release }}/storage {{ $shared }}');
            } else {
                exec('rm -rf {{ $release }}/storage');
            }";
        @else
            mkdir -p {{ $shared }}/{{ $link }};
            @if(strpos($link, '/'))
                mkdir -p {{ $release }}/{{ dirname($link) }};
            @endif
        @endif
        ln -s {{ $shared }}/{{ $link }} {{ $release }}/{{ $link }};
    @endforeach
    @foreach($filelinks as $link)
        ln -s {{ $shared }}/{{ $link }} {{ $release }}/{{ $link }};
    @endforeach



    if [ $has_env = true ]; then

        {{ logMessage("######## Laravel ########") }}

        cd {{ $release }}
        {{--php{{ $php_version }} artisan storage:link--}}
        php{{ $php_version }} artisan migrate --force

        {{--https://laravel.com/docs/9.x/deployment--}}
        php{{ $php_version }} artisan config:cache --quiet
        php{{ $php_version }} artisan view:cache --quiet
        php{{ $php_version }} artisan route:cache --quiet {{-- application avec beaucoup de route --}}


    fi

    {{ logMessage("######## linkcurrent ########") }}


    rm -f {{ $current }};
    ln -s {{ $release }} {{ $current }};
    ls {{ $dir }}/releases | sort -r | tail -n +{{ $releases + 1 }} | xargs -I{} -r rm -rf {{ $dir }}/releases/{};

    exit;
    {{--Problème avec le lien symbolique current mis en cache par apache ou php --}}
    /etc/init.d/apache2 reload;

    echo "Lien // {{ $current }} --> {{ $release }}";

@endtask


@task('rollback')
    rm -f {{ $current }};
    ls {{ $dir }}/releases | tail -n 2 | head -n 1 | xargs -I{} -r ln -s {{ $dir }}/releases/{} {{ $current }};

    {{--TODO composer + migration --}}
@endtask



@task('init', ['confirm' => true])
    {{ logMessage("######## init ########") }}

    su - {{ $user }};
    cd {{ $current }}

    php{{ $php_version }} artisan key:generate --quiet
    php{{ $php_version }} artisan route:clear --quiet
    php{{ $php_version }} artisan config:cache --quiet

    php{{ $php_version }} artisan migrate --force
    php{{ $php_version }} artisan db:seed --force
@endtask
