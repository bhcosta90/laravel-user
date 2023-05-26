<?php

namespace BRCas\LaravelUser\Services;

use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Model;

class UserService
{
    protected Model $user;

    public function __construct()
    {
        $this->user = app(config('bhcosta90-user.user.model'));
    }

    public function index()
    {
        return $this->user->select();
    }

    public function create(array $data)
    {
        $user = $this->user->create($data);
        event(new Registered($user));
        $this->registerRoles($user, $data['roles'] ?: []);
        return $user;
    }

    public function find(string $id)
    {
        return $this->user->find($id);
    }

    public function edit($obj, array $data)
    {
        $obj->update($data);
        $this->registerRoles($obj, $data['roles'] ?: []);
        return $obj;
    }

    public function destroy($obj)
    {
        return $obj->delete();
    }

    private function registerRoles($user, $roles)
    {
        $implements = class_uses(config('bhcosta90-user.user.model'));
        if (in_array('Spatie\Permission\Traits\HasRoles', $implements)) {
            $user->roles()->sync($roles);
        }
    }
}
