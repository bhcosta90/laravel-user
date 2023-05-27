<?php

return [
    'template' => env('USER_TEMPLATE'),
    'user' => [
        'service' => '\BRCas\LaravelUser\Services\UserService',
        'model' => '\App\Models\User',
        'table' => ['Nome' => ['field' => 'name'], 'E-mail' => ['field' => 'email']],
        'field' => [
            'active' => 'is_active'
        ],
        'filter' => [
            'like_users|name' => 'Nome do usuário',
            'equal_email' => 'E-mail do usuário',
        ],
        'permission' => [],
        'rules' => [
            'name' => ['required', 'min:3', 'max:150', 'string'],
            'email' => ['required', 'email'],
        ],
        'view' => [
            'index' => 'Relatório do usuário',
            'search' => 'Buscar usuário',
            'register' => 'Novo usuário',
            'create' => 'Cadastrar usuário',
            'edit' => 'Editar usuário',
        ],
        'message' => [
            'store' => 'Usuário criado com sucesso',
            'update' => 'Usuário atualizado com sucesso',
            'destroy' => 'Usuário deletado com sucesso',
            'permission' => 'Permissões do usuário vinculadas com sucesso',
            'enable' => "Usuário ativo com sucesso",
            'disable' => "Usuário inativado com sucesso",
        ],
        'form' => [
            'create' => '\BRCas\LaravelUser\Forms\UserCreateForm',
            'edit' => '\BRCas\LaravelUser\Forms\UserEditForm'
        ]
    ],
    "role" => [
        'permission' => [],
        'view' => [
            'index' => 'Relatório do grupo de acesso',
            'search' => 'Buscar grupo de acesso',
            'register' => 'Novo grupo de acesso',
            'create' => 'Cadastrar grupo de acesso',
            'edit' => 'Editar grupo de acesso',
        ],
    ],
    'profile' => [
        'form' => '\BRCas\LaravelUser\Forms\Profile\ProfileForm',
        'service' => '\BRCas\LaravelUser\Services\ProfileService',
        'message' => [
            'update' => 'Perfil atualizado com sucesso',
            'password' => 'Senha alterada com sucesso',
        ],
        'view' => [
            'profile' => 'Alterar meus dados',
            'password' => 'Alterar minha senha',
        ],
    ]
];
