<?php

namespace BRCas\LaravelUser\Forms\Profile;

use Kris\LaravelFormBuilder\Form;

class ProfileForm extends Form
{
    public function buildForm()
    {
        $this->add('name', 'text', [
            'rules' => config('bhcosta90-user.user.rules.create.name'),
            'label' => __('Nome'),
        ]);

        $this->add('email', 'email', [
            'rules' => config('bhcosta90-user.user.rules.create.email'),
            'label' => __('E-mail'),
        ]);
    }
}
