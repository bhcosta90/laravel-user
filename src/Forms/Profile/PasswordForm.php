<?php

namespace BRCas\User\Forms\Profile;

use Kris\LaravelFormBuilder\{Field, Form};

class PasswordForm extends Form
{
    public function buildForm()
    {
        $this->add('password_old', Field::PASSWORD, [
            'label' => __('Password'),
            'rules' => 'required|min:6|max:16'
        ])->add('password', 'repeated', [
            'type' => 'password',
            'second_name' => 'password_confirmation',
            'first_options' => [
                'label' => __('New Password'),
                'rules' => 'required|confirmed',
            ],
            'second_options' => [
                'label' => __('Confirm Password')
            ],
        ]);
    }
}
