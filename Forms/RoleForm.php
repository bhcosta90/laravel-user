<?php

namespace Costa\User\Forms;

use Costa\User\Services\UserService;
use Kris\LaravelFormBuilder\Field;
use Kris\LaravelFormBuilder\Form;

class RoleForm extends Form
{
    public function buildForm()
    {
        $uuid = $this->request->route('user');
        $field = config('costa_user.router.user');

        $this->add('name', Field::TEXT, [
            'label' => 'Nome',
            'rules' => ['required', 'string', 'max:255'],
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
