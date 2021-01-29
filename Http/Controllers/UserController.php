<?php

namespace Costa\User\Http\Controllers;


use Costa\Package\Abstracts\ControllerResource;

class UserController extends ControllerResource
{
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


}
