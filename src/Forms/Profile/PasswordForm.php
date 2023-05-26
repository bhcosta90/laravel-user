<?php

namespace BRCas\LaravelUser\Forms\Profile;

use Kris\LaravelFormBuilder\Form;

class PasswordForm extends Form
{
    public function buildForm()
    {
        $this->add('password_actual', 'password', [
            'rules' => ['required'],
            'label' => __('Senha atual'),
        ]);

        $this->add('password', 'password', [
            'rules' => ['required', 'confirmed'],
            'label' => __('Nova senha'),
        ]);

        $this->add('password_confirmation', 'password', [
            'rules' => ['required'],
            'label' => __('Confirmar nova senha'),
        ]);
    }
}
