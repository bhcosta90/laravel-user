<?php

namespace Costa\User\Forms;

use Kris\LaravelFormBuilder\Field;
use Kris\LaravelFormBuilder\Form;

class RoleForm extends Form
{
    public function buildForm()
    {
        $uuid = $this->request->route('role');
        $field = config('costa_user.router.role');

        $this->add('name', Field::TEXT, [
            'label' => 'Nome',
            'rules' => ['required', 'string', 'max:255', "unique:roles,name,{$uuid},{$field}"],
        ]);

        $this->permissions();
    }

    private function permissions()
    {
        $objService = app(config('costa_user.services.user'));
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
}
