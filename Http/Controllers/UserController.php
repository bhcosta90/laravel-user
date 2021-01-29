<?php

namespace Costa\User\Http\Controllers;


use Costa\Package\Abstracts\ControllerResource;
use Costa\Package\Traits\Controller\HasPermission;

class UserController extends ControllerResource
{
    use HasPermission;

    public function service(): string
    {
        return config('costa_user.services.user');
    }

    public function form(): string
    {
        return config('costa_user.forms.user');
    }

    protected function getNameView(): string
    {
        return 'costa_user::user.user.' . $this->getActionName();
    }

    protected function permissions()
    {
        return config('costa_user.permissions.role');
    }


}
