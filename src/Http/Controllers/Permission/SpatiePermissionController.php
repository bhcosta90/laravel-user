<?php

namespace BRCas\LaravelUser\Http\Controllers\Permission;

use BRCas\Laravel\Abstracts\Traits\PostTrait;
use BRCas\Laravel\Support\RouteSupport;
use BRCas\Laravel\Traits\Support\Permission;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class SpatiePermissionController extends Controller
{
    use Permission, PostTrait;

    public function permissions()
    {
        return [
            'index' => config('bhcosta90-user.user.permission.permission'),
            'update' => config('bhcosta90-user.user.permission.permission'),
        ];
    }

    public function index(string $id)
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

        $action = route(RouteSupport::getRouteActual() . '.update', $id);

        $model = config('bhcosta90-user.user.model');
        $objModel = app($model)->findOrFail($id);
        $modelHasPermission = $objModel->permissions()->pluck('name')->toArray();
        return view('bhcosta90-user::user.permission', compact(
            'modelHasPermission',
            'permissions',
            'model',
            'action'
        ));
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $groupPermission = $data['group'];
        $allParameters = request()->route()->parameters();

        $objModel = app(base64_decode($data['name_model']))->findOrFail(end($allParameters));

        $modelPermissions = app(config('permission.models.permission'));
        $allPermissionGroup = $modelPermissions->select()
            ->where('name', 'like', $groupPermission . "%")
            ->pluck('id');

        return DB::transaction(function() use($objModel, $data, $groupPermission, $allPermissionGroup){
            $objModel->revokePermissionTo($allPermissionGroup)
                ->givePermissionTo($data['permission'][$groupPermission] ?? []);

            return $this->responsePost("update", $objModel, config('bhcosta90-user.user.message.permission'));
        });
    }

    public function service()
    {
        return config('bhcosta90-user.user.service');
    }
}
