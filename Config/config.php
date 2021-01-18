<?php


return [
    'repositories' => [
        'user' => \Costa\User\Repositories\UserRepository::class,
        'role' => \Costa\User\Repositories\RoleRepository::class,
    ],
    'models' => [
        'user' => \Costa\User\Entities\User::class,
        'role' => \Spatie\Permission\Models\Role::class,
    ],
    'services' => [
        'user' => \Costa\User\Services\UserService::class,
        'role' => \Costa\User\Services\RoleService::class,
    ],
    'resources' => [
        'user' => \Costa\User\Http\Resources\UserResource::class,
        'role' => \Costa\User\Http\Resources\RoleResource::class,
    ],
    'forms' => [
        'user' => \Costa\User\Forms\UserForm::class,
        'role' => \Costa\User\Forms\RoleForm::class,
        'password' => \Costa\User\Forms\Profile\PasswordForm::class,
        'profile' => \Costa\User\Forms\Profile\ProfileForm::class
    ],
    'router' => [
        'user' => 'id',
        'role' => 'id',
    ],
    'controllers' => [
        'user' => \Costa\User\Http\Controllers\UserController::class,
        'role' => \Costa\User\Http\Controllers\RoleController::class,
        'profile' => \Costa\User\Http\Controllers\ProfileController::class
    ],
    'permissions' => [
        'user' => [
            'index' => null,
            'show' => null,
            'edit' => null,
            'create' => null,
            'destroy' => null,
        ],
        'role' => [
            'index' => null,
            'show' => null,
            'edit' => null,
            'create' => null,
            'destroy' => null,
        ],
    ],
    'send_email' => true,
    'permission_active' => true,
];
