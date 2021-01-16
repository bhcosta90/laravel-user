<?php


return [
    'models' => ['user' => \Costa\User\Entities\User::class],
    'services' => ['user' => \Costa\User\Services\UserService::class],
    'resources' => ['user' => \Costa\User\Http\Resources\UserResource::class],
    'forms' => [
        'user' => \Costa\User\Forms\UserForm::class,
        'password' => \Costa\User\Forms\Profile\PasswordForm::class,
        'profile' => \Costa\User\Forms\Profile\ProfileForm::class
    ],
    'router' => ['user' => 'id'],
    'controllers' => [
        'user' => \Costa\User\Http\Controllers\UserController::class,
        'profile' => \Costa\User\Http\Controllers\ProfileController::class
    ],
    'permissions' => [
        'email_reset_password' => [],
    ],
    'send_email' => true,
];
