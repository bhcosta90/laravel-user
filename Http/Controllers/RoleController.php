<?php

namespace Costa\User\Http\Controllers;

use Costa\Package\Abstracts\ControllerResource;

class RoleController extends ControllerResource
{
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
}
