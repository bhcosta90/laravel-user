<?php

namespace BRCas\User\Repositories;

use App\Models\User;
use BRCas\Laravel\Exceptions\CustomException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\{Permission, Role};

class UserRepository implements Contracts\UserContract
{
    public function index()
    {
        return User::orderName();
    }

    public function find($id)
    {
        return User::find($id);
    }

    public function edit($obj, array $data, $objUserLogin = null)
    {
        if ($objUserLogin == null)
            $objUserLogin = auth()->user();

        if(!empty($data['password'])){
            $data['password'] = Hash::make($data['password']);
        }

        $ret = $obj->update($data);

        if(class_exists(\Spatie\Permission\Models\Permission::class)){
            $this->registerPermissions($objUserLogin, $obj, $data['permissions'] ?: []);
        }

        if(class_exists(\Spatie\Permission\Models\Role::class)){
            $this->registerRoles($objUserLogin, $obj, $data['roles'] ?: []);
        }

        return $ret;
    }

    public function create(array $data, $objUserLogin = null)
    {
        if ($objUserLogin == null)
            $objUserLogin = auth()->user();

        $objUser = config('user.model.user');

        $data['password'] = Hash::make($data['password']);
        $obj = $objUser::create($data);

        if(class_exists(\Spatie\Permission\Models\Permission::class)){
            $this->registerPermissions($objUserLogin, $obj, $data['permissions'] ?: []);
        }

        if(class_exists(\Spatie\Permission\Models\Role::class)){
            $this->registerRoles($objUserLogin, $obj, $data['roles'] ?: []);
        }

        return $obj;
    }

    public function destroy($obj)
    {
        if (auth()->user() == $obj) throw new CustomException(__('You cannot delete your user'), Response::HTTP_BAD_REQUEST);
        return $obj->delete();
    }

    public function registerPermissions($objUser, $obj, array $permissions)
    {
        foreach ($obj->permissions as $permission) {
            if ($objUser && $objUser->can($permission->name) == false) $permissions[] = $permission->id;
        }

        $permissionAccept = config('user.permissions.user.permission');
        
        if($objUser && ($permissionAccept ==null || $objUser->can($permissionAccept) == false)){
            foreach($permissions as $k => $per){
                $objPermission = Permission::find($per);
                if($objUser->can($objPermission->name) == false) 
                    unset($permissions[$k]);
            }
        }

        $obj->syncPermissions($permissions);
    }

    public function registerRoles($objUser, $obj, array $groups)
    {
        foreach ($obj->roles as $permission) {
            if ($objUser->hasRole($permission->name) == true) $groups[] = $permission->id;
        }
        
        $permissionAccept = config('user.permissions.role.all');

        if($objUser && ($permissionAccept ==null || $objUser->can($permissionAccept) == false)){
            foreach($groups as $k => $per){
                $objPermission = Role::find($per);
                if($objUser->hasRole($objPermission->name) == false) 
                    unset($groups[$k]);
            }
        }

        $obj->syncRoles($groups);
    }

    public function getPermissions($obj): array
    {
        $objPermission = Permission::all();
        $permissions = [];

        foreach ($objPermission as $rs) {
            /**
             * @var User
             */
            $obj = auth()->user();
            list($module, $permission) = explode('|', $rs->name);
            if ($obj->can($rs->name)) {
                $permissions[$module][$rs->id] = __($permission);
            }
        }

        return $permissions;
    }

    public function getRoles($obj): array
    {
        $objPermission = Role::all();
        $permissions = [];

        foreach ($objPermission as $rs) {
            $permission = $rs->name;

            if($obj->can(config('user.permissions.role.all')) || 
                (
                    $rs->permissions->count() &&
                    $obj->can($rs->permissions->first()->name)
                )
            ) {
                $permissions[$rs->id] = __($permission);
            }
        }

        return $permissions;
    }
}
