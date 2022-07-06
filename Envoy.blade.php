@servers(['web' => 'root@XXXXXX'])

@setup
$user = 'XXXXXX';
$depot = 'ssh://git@XXXXXX:2323/XXXXXX';
$depot_remote = 'git@XXXXXX -p 2323';

$php_version = '8.1';

$dirlinks = ['storage'];
$filelinks = ['.env'];

$releases = 3;

if ($env == null) {
echo 'Paramètre --env obligatoire';
die();
} elseif ($env == 'prod') {
$dir = "/home/$user/site";
} else {
$dir = "/home/$user/domains/test.$user/site";
}

$dir = "/home/$user/site";

$shared = $dir . '/shared';
$current = $dir . '/current';
$release = $dir . "/releases/" . date('YmdHis');

@endsetup

@story('deploy')
createrelease
composer
links
laravel
linkcurrent
@endstory


@task('prepare')
mkdir -p /home/{{ $user }}/.ssh;
chown {{ $user }}:{{ $user }} /home/{{ $user }}/.ssh;
cp /root/.ssh/id_rsa /home/{{ $user }}/.ssh;
chown  {{ $user }}:{{ $user }} /home/{{ $user }}/.ssh/id_rsa;

su - {{ $user }};

mkdir -p {{ $shared }};

cd {{ $dir }}
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"

ssh -o StrictHostKeyChecking=no {{ $depot_remote }}
@endtask


@task('createrelease')
echo '######## createrelease ########';

su - {{ $user }};

mkdir -p {{ $release }};

git archive master --remote {{ $depot }} | tar -x -C {{ $release }};
@endtask


@task('composer')
echo '######## composer install ########';

su - {{ $user }};

mkdir -p {{ $shared }}/vendor;
ln -s {{ $shared }}/vendor {{ $release }}/vendor;
cd {{ $release }};
php{{ $php_version }} {{ $dir }}/composer.phar install --no-dev --no-progress;
@endtask

@task('links')
echo '######## links ########';
su - {{ $user }};

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

@endtask

@task('laravel')
echo '######## laravel ########';

su - {{ $user }};


cd {{ $release }}
php -r "if (!file_exists('.env')) { copy('{{ $release }}/.env.example', '.env'); }"

php{{ $php_version }} artisan storage:link
php{{ $php_version }} artisan migrate --force
php{{ $php_version }} artisan cache:clear


{{--TODO
php artisan db:seed
php artisan key:generate--}}
@endtask

@task('linkcurrent')
echo '######## linkcurrent ########';

su - {{ $user }};

rm -f {{ $current }};
ln -s {{ $release }} {{ $current }};
ls {{ $dir }}/releases | sort -r | tail -n +{{ $releases + 1 }} | xargs -I{} -r rm -rf {{ $dir }}/releases/{};
echo "Lien // {{ $current }} --> {{ $release }}";
@endtask


@task('rollback')
rm -f {{ $current }};
ls {{ $dir }}/releases | tail -n 2 | head -n 1 | xargs -I{} -r ln -s {{ $dir }}/releases/{} {{ $current }};

{{--TODO composer + migration --}}
@endtask
