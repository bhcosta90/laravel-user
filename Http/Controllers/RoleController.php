<?php

namespace Costa\User\Http\Controllers;

use Costa\Package\Abstracts\ControllerResource;
use Costa\Package\Traits\Controller\HasPermission;
use Exception;

class RoleController extends ControllerResource
{
    use HasPermission;

    public function __construct()
    {
        $this->runPermissions();

        if (config('costa_user.permission_active') == false) {
            throw new Exception(__('Favor ativar o módulo de permissão'));
        }
    }

    public function service(): string
    {
        return config('costa_user.services.role');
    }

    public function form(): string
    {
        return config('costa_user.forms.role');
    }

    protected function getNameView(): string
    {
        return 'costa_user::user.role.' . $this->getActionName();
    }

    protected function permissions()
    {
        return config('costa_user.permissions.user');
    }


}
