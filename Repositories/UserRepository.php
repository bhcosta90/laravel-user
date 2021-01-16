<?php

namespace Costa\User\Repositories;

use Costa\User\Entities\User;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class UserRepository.
 */
class UserRepository extends BaseRepository implements Contracts\UserContract
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return config('costa_user.models.user');
    }
}
