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

        if (empty($this->request->route('user')) || auth()->user()->super_admin) {
            $this->add('password', Field::PASSWORD, [
                'label' => __('Password'),
                'rules' => 'nullable|min:6|max:16',
                'value' => '',
            ]);
        }

        if (class_exists(Permission::class)
            && class_exists(Role::class)) {
            $this->permissions();
            $this->roles();
        }
    }

    private function permissions()
    {
        $objService = app(config('user.services.user'));
        $permissions = $objService->getPermissions(auth()->user());

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
        $objService = app(config('user.services.user'));
        $permissions = $objService->getRoles(auth()->user());

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
