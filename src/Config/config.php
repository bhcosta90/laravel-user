<?php

return [
    "controllers" => [
        "users" => \BRCas\User\Http\Controller\UserController::class,
        "profile" => \BRCas\User\Http\Controller\ProfileController::class,
    ],
    "services" => [
        "user" => \BRCas\User\Services\UserService::class,
        "profile" => \BRCas\User\Services\ProfileService::class,
    ],
    "forms" => [
        "user" => \BRCas\User\Forms\UserForm::class,
        "profile" => \BRCas\User\Forms\Profile\ProfileForm::class,
        "password" => \BRCas\User\Forms\Profile\PasswordForm::class,
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
            "profile" => "user::user.profile",
        ]
    ],
    "permissions" => [
        "user" => [
            "index" => null,
            "edit" => null,
            "create" => null,
            "delete" => null,
        ]
    ]
];
