<?php

namespace Costa\User\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class UserRepository.
 */
class RoleRepository extends BaseRepository implements Contracts\RoleContract
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return config('costa_user.models.role');
    }
}
