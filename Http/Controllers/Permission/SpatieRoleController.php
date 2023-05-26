<?php

namespace BRCas\LaravelUser\Http\Controllers\Permission;

use BRCas\Laravel\Support\FormSupport;
use BRCas\Laravel\Support\RouteSupport;
use BRCas\Laravel\Traits\Controller\IndexTrait;
use BRCas\Laravel\Traits\Controller\ShowTrait;
use BRCas\Laravel\Traits\Controller\Write\DestroyTrait;
use BRCas\Laravel\Traits\Controller\Write\StoreTrait;
use BRCas\Laravel\Traits\Controller\Write\UpdateTrait;
use BRCas\Laravel\Traits\Support\Permission;
use BRCas\LaravelUser\Forms\Spatie\RoleForm;
use BRCas\LaravelUser\Services\Spatie\RoleService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SpatieRoleController extends Controller
{
    use IndexTrait, StoreTrait, UpdateTrait, DestroyTrait, Permission, ShowTrait;

    public function permissions()
    {
        return config('bhcosta90-user.role.permission');
    }

    protected $indexView = 'bhcosta90-user::role.index';
    protected $createView = 'bhcosta90-user::role.create';
    protected $editView = 'bhcosta90-user::role.edit';
    protected $showView = 'bhcosta90-user::role.show';

    public function service()
    {
        return RoleService::class;
    }

    public function filters()
    {
        return [
            'like_roles|name' => 'Nome do grupo',
        ];
    }

    public function table()
    {
        return [
            'Nome' => ['field' => 'name'],
        ];
    }

    public function formCreate()
    {
        return $this->formEdit();
    }

    public function formEdit()
    {
        return RoleForm::class;
    }

    public function create(FormSupport $formSupport, Request $request)
    {
        $action = property_exists($this, 'actionStore')
            ? $this->actionStore
            : "create";

        $objService = $this->validateService([$action]);

        $form = $formSupport->run(
            $this->formCreate(),
            route(RouteSupport::getRouteActual() . '.store', $request->route()->parameters()),
            null,
            [
                'submit' => 'New'
            ]
        );

        $view = property_exists($this, 'createView')
            ? $this->createView
            : RouteSupport::getRouteActual() . '.create';

        $permissions = [];
        $modelPermissions = app(config('permission.models.permission'));
        $dataPermissions = $modelPermissions->select()
            ->orderBy('name', 'asc')
            ->get();

        foreach ($dataPermissions as $permission) {
            $arrayPermission = explode(' - ', $permission->name);
            $titlePermission = array_shift($arrayPermission);
            if (empty($permissions[$titlePermission])) {
                $permissions[$titlePermission] = [
                    'title' => $titlePermission,
                    'permissions' => [],
                ];
            }

            $permissions[$titlePermission]['permissions'][$permission->name] = implode(' - ', $arrayPermission);
        }

        $modelHasPermission = [];

        return view($view, compact('form', 'permissions', 'modelHasPermission'));
    }

    public function addDataInStore(array $data)
    {
        return [
            'permission' => $data['permission'],
        ];
    }

    public function edit(FormSupport $formSupport, Request $request)
    {
        $actionFind = property_exists($this, 'actionFind')
            ? $this->actionFind
            : "find";

        $actionEdit = property_exists($this, 'actionEdit')
            ? $this->actionEdit
            : "edit";

        $objService = $this->validateService([$actionFind, $actionEdit]);

        $dataParameters = $request->route()->parameters();
        $id = end($dataParameters);

        $obj = $objService->$actionFind($id);

        if (empty($obj)) {
            session()->flash('error', __('Register not found'));
            return redirect()->back();
        }

        $form = $formSupport->run(
            $this->formEdit(),
            route(RouteSupport::getRouteActual() . '.update', $dataParameters),
            $obj,
            [
                'submit' => 'Update'
            ]
        );

        $view = property_exists($this, 'editView')
            ? $this->editView
            : RouteSupport::getRouteActual() . '.edit';

        $permissions = [];
        $modelPermissions = app(config('permission.models.permission'));
        $dataPermissions = $modelPermissions->select()
            ->orderBy('name', 'asc')
            ->get();

        foreach ($dataPermissions as $permission) {
            $arrayPermission = explode(' - ', $permission->name);
            $titlePermission = array_shift($arrayPermission);
            if (empty($permissions[$titlePermission])) {
                $permissions[$titlePermission] = [
                    'title' => $titlePermission,
                    'permissions' => [],
                ];
            }

            $permissions[$titlePermission]['permissions'][$permission->name] = implode(' - ', $arrayPermission);
        }

        $model = config('permission.models.role');
        $objModel = app($model)->findOrFail($id);
        $modelHasPermission = $objModel->permissions()->pluck('name')->toArray();

        return view($view, compact('form', 'permissions', 'modelHasPermission'));
    }

    public function addDataInUpdate(array $data)
    {
        return [
            'permission' => $data['permission'],
        ];
    }
}
