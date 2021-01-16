<?php

namespace Costa\User\Forms\Profile;

use Kris\LaravelFormBuilder\Field;
use Kris\LaravelFormBuilder\Form;

class PasswordForm extends Form
{
    public function buildForm()
    {
        $this->add('password_actual', Field::PASSWORD, [
            'label' => __('Password'),
            'rules' => 'required|min:6|max:16'
        ])/*->add('password_new', 'repeated', [
            'type' => 'password',
            'second_name' => 'password_new_confirmation',
            'first_options' => [
                'label' => __('New Password'),
                'rules' => 'required|confirmed',
            ],
            'second_options' => [
                'label' => __('Confirm Password')
            ],
        ])*/
        ->add('password_new', Field::PASSWORD, [
            'rules' => ['required', 'confirmed', 'min:8'],
            'label' => __('New Password'),
        ])->add('password_new_confirmation', Field::PASSWORD, [
            'rules' => 'required',
            'label' => __('Confirm Password')
        ]);
    }
}
