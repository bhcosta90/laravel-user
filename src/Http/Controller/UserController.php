<?php

namespace BRCas\User\Http\Controller;

use App\Http\Controllers\Controller;
use BRCas\Laravel\Traits\Controller\Web\{Create, Destroy, Edit, Index, Show};
use BRCas\Laravel\Traits\Support\Permission;

class UserController extends Controller
{
    use Index, Edit, Create, Destroy, Show, Permission;

    public function permissions()
    {
        return [
            'index' => config('user.permissions.user.index'),
            'create' => config('user.permissions.user.create'),
            'edit' => config('user.permissions.user.edit'),
            'delete' => config('user.permissions.user.delete'),
        ];
    }

    public function form()
    {
        return config('user.forms.user');
    }

    public function service()
    {
        return config('user.services.user');
    }

    public function table()
    {
        return config('user.tables.user');
    }

    public function filters()
    {
        return config('user.filters.user');
    }

    public function routeBegging()
    {
        return 'admin.users.users';
    }


    public function indexView()
    {
        return config('user.views.users.index');
    }

    public function editView()
    {
        return config('user.views.users.edit');
    }

    public function createView()
    {
        return config('user.views.users.create');
    }

    public function showView()
    {
        return config('user.views.users.show');
    }
}
