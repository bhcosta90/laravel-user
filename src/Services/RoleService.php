<?php

namespace BRCas\User\Services;

use BRCas\User\Repositories\Contracts\RoleContract;
use BRCas\User\Repositories\RoleRepository;
use BRCas\Laravel\Contracts\{Create, Destroy, Edit, Index};
use Spatie\Permission\Models\Permission;

class RoleService implements Index, Create, Destroy, Edit
{

    /**
     * @var RoleRepository $repository
     */
    private $repository;

    public function __construct(RoleContract $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return $this->repository->index();
    }

    public function create($data)
    {
        $obj = $this->repository->create($data);
        return $obj;
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function edit($obj, $data)
    {
        $this->repository->edit($obj, $data);
    }

    public function destroy($obj)
    {
        $obj->delete();
    }

    public function getPermissions($obj){
        return $this->repository->getPermissions($obj);
    }
}
