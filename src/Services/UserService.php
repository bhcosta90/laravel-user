<?php

namespace BRCas\User\Services;

use App\Models\User;
use BRCas\Laravel\Contracts\{Create, Destroy, Edit, Index, Show};
use BRCas\User\Repositories\UserRepository;

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

    public function edit($obj, array $data, $objUser = null)
    {
        return $this->repository->edit($obj, $data, $objUser);
    }

    public function create(array $data, $objUser = null)
    {
        return $this->repository->create($data, $objUser);
    }

    public function destroy($obj)
    {
        return $this->repository->destroy($obj);
    }

    public function getRoles($obj){
        return $this->repository->getRoles($obj);
    }

    public function getPermissions($obj){
        return $this->repository->getPermissions($obj);
    }
}
