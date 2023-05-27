<?php

namespace BRCas\LaravelUser\Forms;

class UserCreateForm extends UserEditForm
{
    public function buildForm()
    {
        parent::buildForm();

        $this->add('password', 'password', [
            'rules' => config('bhcosta90-user.user.rules.create.password'),
            'label' => __('Senha'),
        ]);
    }
}
