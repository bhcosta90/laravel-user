<?php

namespace Costa\User\Forms;

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

        if (app()->isLocal()
            || (
                auth()->user()
                && in_array(auth()->user()->email, config('costa_user.permissions.email_reset_password'))
            )
        ) {
            $this->add('password_updated', Field::PASSWORD, [
                'label' => 'Senha',
                'value' => '',
                'rules' => ['required', "min:3"]
            ]);
        }
    }
}
