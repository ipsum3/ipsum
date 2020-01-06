<?php

return [
    [
        'sections' => [
            [
                'title' => 'Dashboard',
                'icon' => 'fas fa-home',
                'route' => ['admin.dashboard'],
                'url_prefix' => '',
            ],
        ]
    ],
    [
        'title' => 'Site',
        'sections' => [
            [
                'title' => 'Articles',
                'icon' => 'fas fa-edit',
                'submenus' => [
                    [
                        'text' => 'Blog',
                        'route' => ['admin.article.index', 'post'],
                        'url_prefix' => '/article/post*'
                    ],
                    [
                        'text' => "Ajouter un post",
                        'route' => ['admin.article.create', 'post'],
                        'url_prefix' => '/article/post/create'
                    ],
                    [
                        'text' => 'Pages',
                        'route' => ['admin.article.index', 'page'],
                        'url_prefix' => '/article/page*'
                    ],
                    [
                        'text' => 'Catégories',
                        'route' => ['admin.articleCategorie.index'],
                        'url_prefix' => '/article/categorie*'
                    ]
                ]
            ],
            [
                'title' => 'Médias',
                'icon' => 'fas fa-camera',
                'submenus' => [
                    [
                        'text' => 'Bibliothéque',
                        'route' => ['admin.media.index'],
                        'url_prefix' => '/media*'
                    ],
                    [
                        'text' => "Ajouter",
                        'route' => ['admin.media.create', 'post'],
                        'url_prefix' => '/media/create'
                    ],
                ]
            ],
        ]
    ],
    [
        'title' => 'Configuration',
        'sections' => [
            [
                'title' => 'Configuration',
                'icon' => 'fas fa-tools',
                'submenus' => [
                    [
                        'text' => 'Administrateurs',
                        'route' => ['adminUser.index'],
                        'url_prefix' => '/adminUser*',
                        'can' => ['viewAny', \Ipsum\Admin\app\Models\Admin::class],
                    ],
                    [
                        'text' => 'Paramètres',
                        'route' => ['admin.setting.update'],
                        'url_prefix' => '/setting*',
                        'gate' => 'show-settings',
                    ],
                    [
                        'text' => 'Logs',
                        'route' => ['admin.log.index'],
                        'url_prefix' => '/log*',
                        'gate' => 'show-logs',
                    ],
                ]
            ],
        ]
    ],
];