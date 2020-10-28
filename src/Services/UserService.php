<?php

namespace BRCas\User\Services;

use App\Models\User;
use BRCas\Laravel\Exceptions\CustomException;
use BRCas\User\Repositories\UserRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserService
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

    public function edit(User $obj, array $data)
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