<?php

namespace BRCas\LaravelUser\Http\Controllers\Permission;

use BRCas\Laravel\Abstracts\LaravelPackageController;
use BRCas\Laravel\Traits\Support\Permission;
use BRCas\LaravelUser\Forms\Spatie\RoleForm;
use BRCas\LaravelUser\Services\Spatie\RoleService;

class SpatieRoleController extends LaravelPackageController
{
    use Permission;

    public function permissions()
    {
        return config('bhcosta90-user.role.permission');
    }

    public function service()
    {
        return RoleService::class;
    }

    public function getFilter()
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

    public function namespaceView()
    {
        return 'bhcosta90-user::';
    }

    public function createForm()
    {
        return $this->editForm();
    }

    public function editForm()
    {
        return RoleForm::class;
    }

    public function addDataInCreate()
    {
        $modelHasPermission = [];

        return [
            'modelHasPermission' => $modelHasPermission,
            'permissions' => $this->getPermissions(),
        ];
    }

    public function addDataInEdit()
    {
        $modelHasPermission = $this->getModel()->permissions()->pluck('name')->toArray();

        return [
            'modelHasPermission' => $modelHasPermission,
            'permissions' => $this->getPermissions(),
        ];
    }

    private function getPermissions()
    {
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

        return $permissions;
    }

    public function addDataInUpdate(array $data)
    {
        return $this->addDataInStore($data);
    }

    public function addDataInStore(array $data)
    {
        return [
            'permission' => $data['permission'],
        ];
    }
}
