<?php

namespace BRCas\LaravelUser\Http\Controllers;

use BRCas\Laravel\Abstracts\LaravelPackageController;
use BRCas\Laravel\Support\RouteSupport;
use BRCas\Laravel\Traits\Support\Permission;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
            auth()->user()
            && config('bhcosta90-user.user.field.active')
            && auth()->user()->can(config('bhcosta90-user.user.permission.active'))
        ) {
            $table[__('Ativo') . "?"] = [
                'action' => fn ($obj) => str()->is_active("user", route(RouteSupport::getRouteActual() . '.active', $obj->id), $obj->is_active),
                'class' => 'min-column',
            ];
        }

        if (
            in_array('Spatie\Permission\Traits\HasRoles', $implements)
            && auth()->user()
            && auth()->user()->can(config('bhcosta90-user.user.permission.permission'))
        ) {
            $title = __('Vincular permissões');
            $table['_Permissões'] = [
                'action' => fn ($obj) => '<a data-card-title="' . $title . '" href="' . route(RouteSupport::getRouteActual() . '.permission.index', $obj->id) . '" class="btn-warning btn-sm btn-show btn-permission"><i class="fas fa-key"></i></a>',
                'class' => 'min-column',
            ];
        }

        return $table;
    }

    public function active(Request $request)
    {
        $params = $request->route()->parameters();
        $this->validateUser($request);

        $obj = app(config('bhcosta90-user.user.model'));
        $model = $obj->findOrFail(end($params));

        $fieldActive = config('bhcosta90-user.user.field.active');

        if ($model->$fieldActive) {
            $message = config('bhcosta90-user.user.message.disable');
        } else {
            $message = config('bhcosta90-user.user.message.enable');
        }

        $model->$fieldActive = !$model->$fieldActive;
        $model->save();

        return $this->responsePost("active", $model, $message);
    }

    public function destroy(Request $request)
    {
        $this->validateUser($request);
        return parent::destroy($request);
    }

    protected function namespaceView()
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

    protected function validateUser(Request $request)
    {
        $params = $request->route()->parameters();

        if (request()->user()->id === end($params)) {
            throw ValidationException::withMessages([
                'is_active' => __('Admin user cannot be deleted or inactivated')
            ]);
        }
    }
}
