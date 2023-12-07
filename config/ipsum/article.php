<?php

return [

    'types' => [
        'page',
        'post',
    ],

    'groupes' => [
        'default' => [
            'conditions' => [

            ],
            'categorie' => false,
            'medias' => [
                ['groupe' => '']
            ],
            'custom_fields' => [
                [
                    'name' => 'titre',
                    'label' => 'Titre',
                    'description' => 'sss',
                    'defaut' => '',
                    'type' => 'input',
                    'rules' => 'required',
                ],
                [
                    'name' => 'questions',
                    'label' => 'Questions',
                    'type' => 'repeater',
                    'rules' => 'nullable',
                    'fields' => [
                        [
                            'name' => 'question',
                            'label' => 'Question',
                            'description' => '',
                            'defaut' => '',
                            'type' => 'input',
                            'rules' => 'nullable',
                        ],
                        [
                            'name' => 'reponse',
                            'label' => 'Réponse',
                            'description' => '',
                            'defaut' => '',
                            'type' => 'html-simple',
                            'rules' => 'nullable',
                        ],
                    ],
                ],
            ],
            'custom_blocs' => [
                [
                    'name' => 'texte',
                    'label' => 'Texte',
                    'fields' => [
                        [
                            'name' => 'texte',
                            'label' => 'Texte',
                            'description' => '',
                            'defaut' => '',
                            'type' => 'html',
                            'rules' => 'nullable',
                        ]
                    ],
                ],
                [
                    'name' => 'faq',
                    'label' => 'FAQ',
                    'fields' => [
                        [
                            'name' => 'titre',
                            'label' => 'Titre',
                            'description' => 'sss',
                            'defaut' => '',
                            'type' => 'input',
                            'rules' => 'nullable',
                        ],
                        [
                            'name' => 'questions',
                            'label' => 'Questions',
                            'description' => 'dddddddd',
                            'type' => 'repeater',
                            'fields' => [
                                [
                                    'name' => 'question',
                                    'label' => 'Question',
                                    'description' => '',
                                    'defaut' => '',
                                    'type' => 'input',
                                    'rules' => 'nullable',
                                ],
                                [
                                    'name' => 'reponse',
                                    'label' => 'Réponse',
                                    'description' => '',
                                    'defaut' => '',
                                    'type' => 'html-simple',
                                    'rules' => 'nullable',
                                ],
                            ],
                        ],

                    ],
                ],
                [
                    'name' => 'higlight',
                    'label' => 'Mise en avant',
                    'fields' => [
                        [
                            'name' => 'titre',
                            'label' => 'Titre',
                            'description' => '',
                            'defaut' => '',
                            'type' => 'input',
                            'rules' => 'required',
                        ],
                        [
                            'name' => 'texte',
                            'label' => 'Texte',
                            'description' => '',
                            'defaut' => '',
                            'type' => 'html',
                            'rules' => 'required',
                        ],
                        [
                            'name' => 'type',
                            'label' => 'Type',
                            'description' => '',
                            'defaut' => '',
                            'options' => [
                                'type-yellow' => 'jaune',
                                'type-orange' => 'orange',
                                'type-blue-dark' => 'bleu foncé',
                                'type-blue-regular' => 'bleu',
                                'type-blue-light' => 'bleu clair',
                                'type-green' => 'vert',
                            ],
                            'type' => 'select',
                            'rules' => 'required',
                        ],
                    ],
                ],
            ],
            'is_guarded' => false,
            'publication' => [
                'has_date' => true,
                'has_etat' => true,
            ],
            'has_extrait' => true,
            'has_texte' => true,
        ],

        'page' => [
            'conditions' => [
                'article_types' => ['page']
            ],
            'is_guarded' => true
        ],

        'post' => [
            'conditions' => [
                'article_types' => ['post']
            ],
            'categorie' => [
                'type' => 'post'
            ]
        ],
    ],

    'etats' => [
        'publie' => 'Publié',
        'brouillon' => 'Brouillon'
    ],

    'translatable_attributes_adds' => [],
];
