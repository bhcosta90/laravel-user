<?php

namespace Costa\User\Forms;

use Costa\User\Services\UserService;
use Kris\LaravelFormBuilder\Field;
use Kris\LaravelFormBuilder\Form;

class UserForm extends Form
{
    public function buildForm()
    {
        $uuid = $this->request->route('user');
        $field = config('costa_user.router.user');

        $this->add('name', Field::TEXT, [
            'label' => 'Nome',
            'rules' => ['required', 'string', 'max:255'],
        ])->add('email', Field::EMAIL, [
            'label' => 'Email',
            'rules' => ['required', "max:255", "unique:users,email,{$uuid},{$field}"]
        ]);

        $verify = UserService::canUpdatePassword();

        if (config('costa_user.send_email') && (empty($uuid) || $verify)) {
            $this->add('send', Field::CHECKBOX, [
                'label' => 'Enviar por e-mail a senha do usuário',
                'attr' => [
                    'checked' => !(bool)$uuid,
                ],
                'rules' => ['nullable']
            ]);
        }

        if ($uuid && $verify) {
            $this->add('password_updated', Field::PASSWORD, [
                'label' => 'Senha',
                'value' => '',
                'rules' => ['nullable', "min:3"]
            ]);
        }

        if(config('costa_user.permission_active')){
            $this->permissions();
            $this->roles();
        }
    }

    private function permissions()
    {
        $objService = app(config('costa_user.services.user'));
        $permissions = $objService->getPermissions(auth()->user());

        if (!empty($permissions)) {
            $this->add('permissions', Field::SELECT, [
                'label' => __("Permissions"),
                'attr' => [
                    'multiple' => true,
                ],
                'choices' => $permissions,
            ]);
        }
    }

    private function roles()
    {
        $objService = app(config('costa_user.services.user'));
        $permissions = $objService->getRoles(auth()->user());

        if (!empty($permissions)) {
            $this->add('roles', Field::SELECT, [
                'label' => __("Roles"),
                'attr' => [
                    'multiple' => true,
                ],
                'choices' => $permissions,
            ]);
        }
    }
}
