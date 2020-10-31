<?php

return [
    "controllers" => [
        "users" => \BRCas\User\Http\Controller\UserController::class,
        "roles" => \BRCas\User\Http\Controller\RoleController::class,
        "profile" => \BRCas\User\Http\Controller\ProfileController::class,
    ],
    "services" => [
        "user" => \BRCas\User\Services\UserService::class,
        "role" => \BRCas\User\Services\RoleService::class,
        "profile" => \BRCas\User\Services\ProfileService::class,
    ],
    "forms" => [
        "user" => \BRCas\User\Forms\UserForm::class,
        "role" => \BRCas\User\Forms\RoleForm::class,
        "profile" => \BRCas\User\Forms\Profile\ProfileForm::class,
        "password" => \BRCas\User\Forms\Profile\PasswordForm::class,
    ],
    "layout" => "layouts.app",
    "tables" => [
        "user" => [
            'Name' => ['field' => 'name'],
            'Email' => ['field' => 'email'],
        ],
        "role" => [
            'Name' => ['field' => 'name'],
        ],
    ],
    "filters" => [
        "user" => [
            'filter_name' => 'Name',
            'equal_email' => 'E-mail',
        ],
        "role" => [
            'filter_name' => 'Name',
        ],
    ],
    "views" => [
        "users" => [
            "index" => "user::user.index",
            "edit" => "user::user.edit",
            "create" => "user::user.create",
            "show" => "user::user.show",
            "profile" => "user::user.profile",
        ],
        "roles" => [
            "index" => "user::role.index",
            "edit" => "user::role.edit",
            "create" => "user::role.create",
            "show" => "user::role.show",
        ]
    ],
    "permissions" => [
        "user" => [
            "index" => null,
            "edit" => null,
            "create" => null,
            "delete" => null,
        ],
        "role" => [
            "index" => null,
            "edit" => null,
            "create" => null,
            "delete" => null,
        ]
    ],
    "model" => [
        "user" => \BRCas\User\Models\User::class
    ]
];
