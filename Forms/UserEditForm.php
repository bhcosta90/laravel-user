<?php

namespace BRCas\LaravelUser\Forms;

use Kris\LaravelFormBuilder\Form;

class UserEditForm extends Form
{
    public function buildForm()
    {
        $this->add('name', 'text', [
            'rules' => config('bhcosta90-user.user.rules.edit.name'),
            'label' => __('Nome'),
        ]);

        $this->add('email', 'email', [
            'rules' => config('bhcosta90-user.user.rules.edit.email'),
            'label' => __('E-mail'),
        ]);

        $implements = class_uses(config('bhcosta90-user.user.model'));
        if (in_array('Spatie\Permission\Traits\HasRoles', $implements)) {
            $select = [
                'label' => __('Grupo de acesso'),
                'choices' => app(config('permission.models.role'))->orderBy('name')->pluck('name', 'id')->toArray(),
                'attr' => [
                    'multiple' => config('bhcosta90-user.user.form.role_multiple')
                ]
            ];

            if (empty(config('bhcosta90-user.user.form.role_multiple'))) {
                $select += [
                    'empty_value' => __('Selecione') . '...',
                ];
            }
            $this->add('roles', 'select', $select);
        }
    }
}
