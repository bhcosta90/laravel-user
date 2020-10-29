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

    public function edit($obj, array $data)
    {
        return $this->repository->edit($obj, $data);
    }

    public function create(array $data)
    {
        $this->repository->create($data);
    }

    public function destroy($obj)
    {
        return $this->repository->destroy($obj);
    }
}
