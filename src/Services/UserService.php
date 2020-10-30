<?php

namespace BRCas\User\Services;

use App\Models\User;
use BRCas\Laravel\Contracts\{Create, Destroy, Edit, Index, Show};
use BRCas\User\Repositories\UserRepository;
use Spatie\Permission\Models\{Permission, Role};

class UserService implements Index, Edit, Show, Create, Destroy
{

    /**
     * @var UserRepository
     */
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return $this->repository->index();
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function edit($obj, array $data)
    {
        return $this->repository->edit($obj, $data);
    }

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function destroy($obj)
    {
        return $this->repository->destroy($obj);
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

            if($obj->can('Visualizar todos os grupos') || 
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
