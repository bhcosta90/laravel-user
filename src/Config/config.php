<?php

return [
    "controllers" => [
        "users" => \BRCas\User\Http\Controller\UserController::class,
    ],
    "services" => [
        "user" => \BRCas\User\Services\UserService::class,
    ],
    "forms" => [
        "user" => \BRCas\User\Forms\UserForm::class,
    ],
    "layout" => "layouts.app",
    "tables" => [
        "user" => [
            'Name' => ['field' => 'name'],
            'Email' => ['field' => 'email'],
        ],
    ],
    "filters" => [
        "user" => [
            'filter_name' => 'Name',
            'equal_email' => 'E-mail',
        ],
    ],
    "views" => [
        "users" => [
            "index" => "user::user.index",
            "edit" => "user::user.edit",
            "create" => "user::user.create",
            "show" => "user::user.show",
        ]
    ],
    "permissions" => [
        "user" => [
            "index" =>  null,
            "edit" => null,
            "create" => null,
            "delete" => null,
        ]
    ]
];
