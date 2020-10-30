<?php

namespace BRCas\User\Repositories;

use App\Models\User;
use BRCas\Laravel\Exceptions\CustomException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

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

    public function edit($obj, array $data)
    {
        if(!empty($data['password'])){
            $data['password'] = Hash::make($data['password']);
        }

        $ret = $obj->update($data);

        if(class_exists(\Spatie\Permission\Models\Permission::class)){
            $this->registerPermissions($obj, $data['permissions'] ?: []);
        }

        if(class_exists(\Spatie\Permission\Models\Role::class)){
            $this->registerRoles($obj, $data['roles'] ?: []);
        }

        return $ret;
    }

    public function create(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $obj = User::create($data);

        if(class_exists(\Spatie\Permission\Models\Permission::class)){
            $this->registerPermissions($obj, $data['permissions'] ?: []);
        }

        if(class_exists(\Spatie\Permission\Models\Role::class)){
            $this->registerRoles($obj, $data['roles'] ?: []);
        }

        return $obj;
    }

    public function destroy($obj)
    {
        if (auth()->user() == $obj) throw new CustomException(__('You cannot delete your user'), Response::HTTP_BAD_REQUEST);
        return $obj->delete();
    }

    public function registerPermissions($obj, array $permissions)
    {
        /**
         * @var User;
         */
        if ($objUser = auth()->user()) {

            foreach ($obj->permissions as $permission) {
                if ($objUser->can($permission->name) == false) $permissions[] = $permission->id;
            }

            $obj->syncPermissions($permissions);
        }
    }

    public function registerRoles($obj, array $groups)
    {
        /**
         * @var User
         */
        if (($objUser = auth()->user())) {
            foreach ($obj->roles as $permission) {
                if ($objUser->hasRole($permission->name) == false) $groups[] = $permission->id;
            }

            $obj->syncRoles($groups);
        }
    }
}
