<?php

namespace BRCas\LaravelUser\Http\Controllers;

use BRCas\Laravel\Support\RouteSupport;
use BRCas\Laravel\Traits\Controller\CreateTrait;
use BRCas\Laravel\Traits\Controller\EditTrait;
use BRCas\Laravel\Traits\Controller\IndexTrait;
use BRCas\Laravel\Traits\Controller\ShowTrait;
use BRCas\Laravel\Traits\Controller\Write\DestroyTrait;
use BRCas\Laravel\Traits\Support\Permission;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    use IndexTrait, CreateTrait, EditTrait, DestroyTrait, Permission, ShowTrait;

    public function permissions()
    {
        return config('bhcosta90-user.user.permission');
    }

    protected $indexView = 'bhcosta90-user::user.index';
    protected $createView = 'bhcosta90-user::user.create';
    protected $editView = 'bhcosta90-user::user.edit';
    protected $showView = 'bhcosta90-user::user.show';

    public function service()
    {
        return config('bhcosta90-user.user.service');
    }

    public function filters()
    {
        return [
            'like_users|name' => 'Nome do usuário',
            'equal_email' => 'E-mail do usuário',
        ];
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
            $table[__('_Permissões')] = [
                'action' => fn ($obj) => '<a href="' . route(RouteSupport::getRouteActual() . '.permission.index', $obj->id) . '" class="btn-warning btn-sm btn-show"><i class="fas fa-key"></i></a>',
                'class' => 'min-column',
            ];
        }

        return $table;
    }

    public function formCreate()
    {
        return config('bhcosta90-user.user.form.create');
    }

    public function formEdit()
    {
        return config('bhcosta90-user.user.form.edit');
    }
}
