<?php

return [
    'user' => [
        'service' => '\BRCas\LaravelUser\Services\UserService',
        'model' => '\App\Models\User',
        'table' => ['Nome' => ['field' => 'name'], 'E-mail' => ['field' => 'email']],
        'permission' => [],
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
    ]
];
