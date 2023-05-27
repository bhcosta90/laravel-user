<?php

namespace BRCas\LaravelUser\Forms;

use Kris\LaravelFormBuilder\Form;

class UserEditForm extends Form
{
    public function buildForm()
    {
        $id = request()->route()->parameter('user');

        $implements = class_uses(config('bhcosta90-user.user.model'));

        $this->add('name', 'text', [
            'rules' => config('bhcosta90-user.user.rules.name'),
            'label' => __('Nome'),
        ]);

        $filterEmail = "unique:users,email,{$id},id";

        if (in_array('Stancl\Tenancy\Database\Concerns\BelongsToTenant', $implements)) {
            $tenant = tenant('id');
            $filterEmail .= ",tenant_id,{$tenant}";
        }

        $this->add('email', 'email', [
            'rules' => array_merge(config('bhcosta90-user.user.rules.email'), [$filterEmail]),
            'label' => __('E-mail'),
        ]);

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
