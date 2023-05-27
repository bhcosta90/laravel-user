<?php

namespace BRCas\LaravelUser\Http\Controllers;

use BRCas\Laravel\Abstracts\LaravelPackageController;
use BRCas\Laravel\Support\RouteSupport;
use BRCas\Laravel\Traits\Support\Permission;

class UserController extends LaravelPackageController
{
    use Permission;

    public function permissions()
    {
        return config('bhcosta90-user.user.permission');
    }

    public function service()
    {
        return config('bhcosta90-user.user.service');
    }

    public function table()
    {
        $table = config('bhcosta90-user.user.table');

        $implements = class_uses(config('bhcosta90-user.user.model'));
        if (
            in_array('Spatie\Permission\Traits\HasRoles', $implements)
            && auth()->user()
            && auth()->user()->can(config('bhcosta90-user.user.permission.permission'))
        ) {
            $table['_Permissões'] = [
                'action' => fn ($obj) => '<a href="' . route(RouteSupport::getRouteActual() . '.permission.index', $obj->id) . '" class="btn-warning btn-sm btn-show"><i class="fas fa-key"></i></a>',
                'class' => 'min-column',
            ];
        }

        return $table;
    }

    public function namespaceView()
    {
        return 'bhcosta90-user::user.';
    }

    protected function getFilter()
    {
        return config('bhcosta90-user.user.filter');
    }

    protected function createForm()
    {
        return config('bhcosta90-user.user.form.create');
    }

    protected function editForm()
    {
        return config('bhcosta90-user.user.form.edit');
    }

    protected function messageStore()
    {
        return config('bhcosta90-user.user.message.store');
    }

    protected function messageUpdate()
    {
        return config('bhcosta90-user.user.message.update');
    }

    protected function messageDestroy()
    {
        return config('bhcosta90-user.user.message.destroy');
    }
}
