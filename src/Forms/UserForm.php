<?php

namespace BRCas\User\Forms;

use App\Models\User;
use Kris\LaravelFormBuilder\{Field, Form};
use Spatie\Permission\Models\{Permission, Role};

class UserForm extends Form
{
    public function buildForm()
    {
        $id = $this->request->route('user');

        $this
            ->add('name', Field::TEXT, [
                'label' => __('Name'),
                'rules' => 'required|min:5'
            ])
            ->add('email', Field::EMAIL, [
                'label' => __('Email'),
                'rules' => "required|email|min:5|unique:users,email,{$id},id"
            ]);

        if (empty($this->request->route('user'))) {
            $this->add('password', Field::PASSWORD, [
                'label' => __('Password'),
                'rules' => 'required|min:6|max:16'
            ]);
        }

        if(class_exists(Permission::class)
            && class_exists(Role::class)){
            $this->permissions();
            $this->roles();
        }
    }

    private function permissions()
    {
        $objPermission = Permission::all();
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

    private function roles()
    {
        /**
         * @var User
         */
        $objUser = auth()->user();
        $objPermission = Role::all();
        $permissions = [];

        foreach ($objPermission as $rs) {
            /**
             * @var User
             */
            $permission = $rs->name;

            if($objUser->can($rs->permissions->first()->name)) {
                $permissions[$rs->id] = __($permission);
            }
        }

        if (!empty($permissions)) {
            $this->add('roles', Field::SELECT, [
                'label' => __("Roles"),
                'attr' => [
                    'multiple' => true,
                ],
                'choices' => $permissions,
            ]);
    }
    }
}
