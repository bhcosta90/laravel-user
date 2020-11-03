<?php

namespace BRCas\User\Forms;

use Kris\LaravelFormBuilder\Field;
use Kris\LaravelFormBuilder\Form;

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

        $objService = app(config('user.services.role'));
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
