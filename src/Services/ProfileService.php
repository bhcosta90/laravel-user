<?php


namespace BRCas\User\Services;


use BRCas\User\Repositories\Contracts\ProfileContract;
use BRCas\User\Repositories\ProfileRepository;

class ProfileService
{
    /**
     * @var ProfileRepository
     */
    private $repository;

    public function __construct(ProfileContract $repository)
    {
        $this->repository = $repository;
    }

    public function updateProfile($name, $email)
    {
        $this->repository->updateProfile($name, $email);
    }

    public function updatePassword($password)
    {
        $this->repository->updatePassword($password);
    }
}
