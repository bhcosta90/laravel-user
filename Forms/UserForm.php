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
    }
}
