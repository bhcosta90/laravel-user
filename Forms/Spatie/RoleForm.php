<?php

namespace BRCas\LaravelUser\Forms\Spatie;

use Kris\LaravelFormBuilder\Form;

class RoleForm extends Form
{
    public function buildForm()
    {
        $this->add('name', 'text', [
            'rules' => config('bhcosta90-user.role.rules.name'),
            'label' => config('bhcosta90-user.role.name'),
        ]);
    }
}
