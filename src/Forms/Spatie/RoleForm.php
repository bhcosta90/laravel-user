<?php

namespace BRCas\LaravelUser\Forms\Spatie;

use Kris\LaravelFormBuilder\Form;

class RoleForm extends Form
{
    public function buildForm()
    {
        $id = request()->route()->parameter('role');
        $table = config('permission.table_names.roles');
        $implements = class_uses(config('bhcosta90-user.user.model'));
        $filterName = "unique:{$table},name,{$id},id";

        if (in_array('Stancl\Tenancy\Database\Concerns\BelongsToTenant', $implements)) {
            $tenant = tenant('id');
            $filterName .= ",tenant_id,{$tenant}";
        }

        $this->add('name', 'text', [
            'rules' => array_merge(config('bhcosta90-user.role.rules.name'), [$filterName]),
            'label' => config('bhcosta90-user.role.view.label')
        ]);
    }
}
