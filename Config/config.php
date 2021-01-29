<?php


use Costa\User\Entities\User;
use Costa\User\Forms\Profile\PasswordForm;
use Costa\User\Forms\Profile\ProfileForm;
use Costa\User\Forms\RoleForm;
use Costa\User\Forms\UserForm;
use Costa\User\Http\Controllers\ProfileController;
use Costa\User\Http\Controllers\RoleController;
use Costa\User\Http\Controllers\UserController;
use Costa\User\Http\Resources\RoleResource;
use Costa\User\Http\Resources\UserResource;
use Costa\User\Repositories\RoleRepository;
use Costa\User\Repositories\UserRepository;
use Costa\User\Services\RoleService;
use Costa\User\Services\UserService;
use Spatie\Permission\Models\Role;

return [
    'repositories' => [
        'user' => UserRepository::class,
        'role' => RoleRepository::class,
    ],
    'models' => [
        'user' => User::class,
        'role' => Role::class,
    ],
    'services' => [
        'user' => UserService::class,
        'role' => RoleService::class,
    ],
    'resources' => [
        'user' => UserResource::class,
        'role' => RoleResource::class,
    ],
    'forms' => [
        'user' => UserForm::class,
        'role' => RoleForm::class,
        'password' => PasswordForm::class,
        'profile' => ProfileForm::class
    ],
    'router' => [
        'user' => 'id',
        'role' => 'id',
    ],
    'controllers' => [
        'user' => UserController::class,
        'role' => RoleController::class,
        'profile' => ProfileController::class
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
