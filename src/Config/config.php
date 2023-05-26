<?php

use BRCas\LaravelUser\Forms\UserCreateForm;
use BRCas\LaravelUser\Forms\UserEditForm;
use BRCas\LaravelUser\Services\UserService;
use Illuminate\Validation\Rules\Password;

return [
    'template' => null,
    'title' => 'pt-1 pb-0 title',
    'button' => ['add' => 'btn btn-light btn-sm'],
    'user' => [
        'table' => ['Nome' => ['field' => 'name'], 'E-mail' => ['field' => 'email']],
        'service' => UserService::class,
        'model' => \App\Models\User::class,
        'permission' => [
            // 'index' => 'Usuário - Listar',
            // 'create' => 'Usuário - Cadastrar',
            // 'edit' => 'Usuário - Editar',
            // 'delete' => 'Usuário - Deletar',
            // 'permission' => 'Usuário - Vincular permissão'
        ],
        'rules' => [
            'create' => [
                'name' => ['required', 'string', 'min:2', 'max:150'],
                'email' => ['required', 'email', 'min:2', 'max:150'],
                'password' => ['required', Password::defaults()],
            ],
            'edit' => [
                'name' => ['required', 'string', 'min:2', 'max:150'],
                'email' => ['required', 'email', 'min:2', 'max:150'],
            ]
        ],
        'form' => [
            'create' => UserCreateForm::class,
            'edit' => UserEditForm::class,
            'role_multiple' => false,
        ]
    ],
    'role' => [
        'title' => 'Grupo de acesso',
        'filter' => 'Filtrar grupo de acesso',
        'name' => "Nome",
        'new' => 'Cadastrar grupo de acesso',
        'edit' => 'Editar grupo de acesso',
        'rules' => [
            'name' => ['required', 'string', 'min:2', 'max:150'],
        ],
        'permission' => [
            // 'index' => 'Grupo - Listar',
            // 'create' => 'Grupo - Cadastrar',
            // 'edit' => 'Grupo - Editar',
            // 'delete' => 'Grupo - Deletar',
        ],
    ]
];
