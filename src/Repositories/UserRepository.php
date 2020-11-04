<?php

namespace BRCas\User\Repositories;

use BRCas\Laravel\Exceptions\CustomException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\{Permission, Role};

class UserRepository implements Contracts\UserContract
{
    public function index()
    {
        $objUser = app(config('user.model.user'));
        return $objUser->orderName();
    }

    public function find($id)
    {
        $objUser = app(config('user.model.user'));
        return $objUser->find($id);
    }

    public function edit($obj, array $data, $objUserLogin = null)
    {
        if ($objUserLogin == null)
            $objUserLogin = auth()->user();

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $ret = $obj->update($data);

        $this->registerPermissions($obj, $data['permissions'] ?? []);
        $this->registerRoles($obj, $data['roles'] ?? []);

        return $ret;
    }

    public function registerPermissions($obj, array $permissions)
    {
        $obj->syncPermissions($permissions);
    }

    public function registerRoles($obj, array $groups)
    {
        $obj->syncRoles($groups);
    }

    public function create(array $data, $objUserLogin = null)
    {
        if ($objUserLogin == null)
            $objUserLogin = auth()->user();

        $objUser = config('user.model.user');

        $data['password'] = Hash::make($data['password']);
        $obj = $objUser::create($data);

        $this->registerPermissions($obj, $data['permissions'] ?? []);
        $this->registerRoles($obj, $data['roles'] ?? []);

        return $obj;
    }

    public function destroy($obj)
    {
        if (auth()->user() == $obj) throw new CustomException(__('You cannot delete your user'), Response::HTTP_BAD_REQUEST);
        return $obj->delete();
    }

    public function getPermissions($obj): array
    {
        $objPermission = Permission::all();
        $permissions = [];

        foreach ($objPermission as $rs) {
            list($module, $permission) = explode('|', $rs->name);
            $permissions[trim($module)][$rs->id] = __(trim($permission));
        }

        return $permissions;
    }

    public function getRoles($obj): array
    {
        $objPermission = Role::all();
        $permissions = [];

        foreach ($objPermission as $rs) {
            $permissions[$rs->id] = __($rs->name);
        }

        return $permissions;
    }
}
