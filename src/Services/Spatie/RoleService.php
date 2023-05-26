<?php

namespace BRCas\LaravelUser\Services\Spatie;

use Illuminate\Database\Eloquent\Model;

class RoleService
{
    protected Model $user;

    public function __construct()
    {
        $this->role = app(config('permission.models.role'));
    }

    public function index()
    {
        return $this->role->select();
    }

    public function store(array $data)
    {
        $user = $this->role->create($data);
        $user->syncPermissions($data['permission'] ?? []);
        return $user;
    }

    public function find(string $id)
    {
        return $this->role->find($id);
    }

    public function update($obj, array $data)
    {
        $obj->update($data);
        $obj->syncPermissions($data['permission'] ?? []);
        return $obj;
    }

    public function destroy($obj)
    {
        return $obj->delete();
    }
}
