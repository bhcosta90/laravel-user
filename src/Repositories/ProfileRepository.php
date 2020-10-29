<?php


namespace BRCas\User\Repositories;


use BRCas\User\Repositories\Contracts\UserContract;

class ProfileRepository implements Contracts\ProfileContract
{
    /**
     * @var UserRepository
     */
    private $user;

    public function __construct(UserContract $user)
    {
        $this->user = $user;
    }
    public function updateProfile($name, $email)
    {
        $obj = auth()->user();

        $this->user->edit($obj, [
            'name' => $name,
            'email' => $email,
        ]);
    }

    public function updatePassword($password)
    {
        $obj = auth()->user();
        $this->user->edit($obj, [
            'password' => $password,
        ]);
    }

}
