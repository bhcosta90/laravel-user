<?php

namespace Costa\User\Forms\Profile;

use Kris\LaravelFormBuilder\Field;
use Kris\LaravelFormBuilder\Form;

class ProfileForm extends Form
{
    public function buildForm()
    {
        $uuid = auth()->user()->id;

        $this->add('name', Field::TEXT, [
            'label' => 'Nome',
            'rules' => ['required', 'string', 'max:255'],
        ])->add('email', Field::EMAIL, [
            'label' => 'Email',
            'rules' => ['required', "max:255", "unique:users,email,{$uuid},id"]
        ])->add('password', Field::PASSWORD, [
            'label' => 'Sua senha atual',
            'rules' => ['required', 'string', 'max:30'],
            'value' => ''
        ]);
    }
}
