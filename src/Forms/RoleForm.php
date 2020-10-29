<?php

namespace BRCas\User\Forms;

use Kris\LaravelFormBuilder\Field;
use Kris\LaravelFormBuilder\Form;
use Spatie\Permission\Models\Permission;

class RoleForm extends Form
{
    public function buildForm()
    {
        $id = $this->request->route('role');

        $this
            ->add('name', Field::TEXT, [
                'label' => __('Name'),
                'rules' => "required|min:5|unique:roles,name,{$id},id"
            ]);

        $objPermission = \Spatie\Permission\Models\Permission::all();
        $permissions = [];

        foreach ($objPermission as $rs) {
            /**
             * @var User
             */
            $user = auth()->user();
            list($module, $permission) = explode('|', $rs->name);
            if ($user->can($rs->name)) {
                $permissions[$module][$rs->id] = __($permission);
            }
        }

        if (!empty($permissions)) {
            $this->add('permissions', Field::SELECT, [
                'label' => __("Permissions"),
                'attr' => [
                    'multiple' => true,
                ],
                'choices' => $permissions,
            ]);
        }
    }
}
