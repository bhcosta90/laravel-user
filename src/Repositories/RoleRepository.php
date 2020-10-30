<?php

namespace BRCas\User\Repositories;

use Spatie\Permission\Models\{Role, Permission};

class RoleRepository implements Contracts\RoleContract
{
    public function index()
    {
        return app(Role::class)->all();
    }

    public function create($data)
    {
        $obj = Role::create($data);
        $this->registerPermissions($obj, $data['permissions'] ?? []);
        return $obj;
    }

    private function registerPermissions($obj, array $permissions)
    {
        /**
         * @var \App\Models\User;
         */
        $objUser = auth()->user();

        foreach ($obj->permissions as $permission) {
            if ($objUser->can($permission->name) == false) $permissions[] = $permission->id;
        }

        $obj->syncPermissions($permissions);
    }

    public function find($id)
    {
        return Role::find($id);
    }

    public function edit($obj, $data)
    {
        $obj->update($data);
        $this->registerPermissions($obj, $data['permissions'] ?? []);
    }

    public function destroy($obj)
    {
        $obj->delete();
    }
    
    public function getPermissions(): array
    {
        $objPermission = Permission::all();
        $permissions = [];

        foreach ($objPermission as $rs) {
            list($module, $permission) = explode('|', $rs->name);
            if ($obj->can($rs->name)) {
                $permissions[$module][$rs->id] = __($permission);
            }
        }

        if (!empty($permissions)) {
            $this->add('permissions', Field::SELECT, [
                'label' => __("Permissions"),
                'attr' => [
                    'multiple' => true,
                ],
                'choices' => $permissions,
            ]);
        }

        return $permissions;
    }
}
