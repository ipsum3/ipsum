<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Ipsum\Core\app\Models\Setting;

class SettingsTableSeeder extends Seeder
{
    public function run()
    {
        $settings = Setting::all()->pluck('key')->toArray();
        foreach ($this->getConfig() as $config) {
            if (! in_array($config['key'], $settings)) {
                Setting::create($config);
            }
        }
    }

    private function getConfig()
    {
        return [
            [
                'group' => 'Général',
                'key' => 'settings.nom_site',
                'name' => 'Nom du site',
                'value' => 'Ipsum 3',
                'type' => 'input',
                'rules' => 'required',
            ],
            [
                'group' => 'Général',
                'key' => 'settings.societe',
                'name' => 'Nom de société',
                'value' => 'Société',
                'type' => 'input',
            ],
            [
                'group' => 'Général',
                'key' => 'settings.adresse',
                'name' => 'Adresse',
                'value' => 'Adresse',
                'type' => 'input',
            ],
            [
                'group' => 'Général',
                'key' => 'settings.cp',
                'name' => 'Code postal',
                'value' => '97200',
                'type' => 'input',
            ],
            [
                'group' => 'Général',
                'key' => 'settings.ville',
                'name' => 'Ville',
                'value' => 'Fort-de-France',
                'type' => 'input',
            ],
            [
                'group' => 'Général',
                'key' => 'settings.telephone',
                'name' => 'Numéro de téléphone principal',
                'value' => '00 00 00 00 00 00',
                'type' => 'tel',
            ],
            [
                'group' => 'Général',
                'key' => 'settings.telephone_secondaire',
                'name' => 'Numéro de téléphone secondaire',
                'value' => '00 00 00 00 00 00',
                'type' => 'tel',
            ],
            [
                'group' => 'Général',
                'key' => 'settings.contact_email',
                'name' => 'Contact email address',
                'value' => 'test@example.com',
                'type' => 'email',
            ],
        ];
    }
}
