<?php

namespace BRCas\User\Http\Controller;

use BRCas\Laravel\Traits\Controller\Web\{Create, Destroy, Edit, Index};
use BRCas\Laravel\Traits\Support\Permission;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class RoleController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    use Index, Create, Edit, Destroy, Permission;

    public function permissions()
    {
        return [
            'index' => config('user.permissions.role.index'),
            'create' => config('user.permissions.role.create'),
            'edit' => config('user.permissions.role.edit'),
            'delete' => config('user.permissions.role.delete'),
        ];
    }

    public function form()
    {
        return config('user.forms.role');
    }

    public function service()
    {
        return config('user.services.role');
    }

    public function table()
    {
        return config('user.tables.role');
    }

    public function filters()
    {
        return config('user.filters.role');
    }

    public function routeBegging()
    {
        return 'admin.users.roles';
    }


    public function indexView()
    {
        return config('user.views.roles.index');
    }

    public function editView()
    {
        return config('user.views.roles.edit');
    }

    public function createView()
    {
        return config('user.views.roles.create');
    }

    public function showView()
    {
        return config('user.views.roles.show');
    }
}
