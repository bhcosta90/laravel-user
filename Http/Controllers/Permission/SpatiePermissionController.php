<?php

namespace BRCas\LaravelUser\Http\Controllers\Permission;

use BRCas\Laravel\Support\RouteSupport;
use BRCas\Laravel\Traits\Support\Permission;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SpatiePermissionController extends Controller
{
    use Permission;

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

    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $groupPermission = $data['group'];
        $objModel = app(base64_decode($data['name_model']))->findOrFail($id);

        $modelPermissions = app(config('permission.models.permission'));
        $allPermissionGroup = $modelPermissions->select()
            ->where('name', 'like', $groupPermission . "%")
            ->pluck('id');

        $objModel->revokePermissionTo($allPermissionGroup)
            ->givePermissionTo($data['permission'][$groupPermission] ?? []);

        $message = __("Permissões vinculadas com sucesso");

        if (!$request->isJson() && empty($request->get('__ajax'))) {
            session()->flash('success', $message);
            return method_exists($this, 'redirectCreate')
                ? $this->redirectCreate($objModel)
                : redirect()->route(RouteSupport::getRouteActual() . ".index", $request->route()->parameters());
        }

        return response()->json([
            'data' => $objModel,
            'msg' => $message,
        ], Response::HTTP_CREATED);
    }
}
