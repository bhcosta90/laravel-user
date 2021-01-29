<?php

namespace Costa\User\Repositories;

use Costa\User\Entities\User;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use Spatie\Permission\Traits\HasRoles;

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
        return config('auth.providers.users.model');
    }

    public function verifySpatiePermission($data)
    {
        $obj = $this->makeModel();

        if (
            (count($data['permissions'] ?? []) > 0 || count($data['roles'] ?? [])) &&
            in_array(HasRoles::class, class_uses($obj)) == false
        ) {
            throw new \Exception(get_class($obj) . ' do not implemented ' . HasRoles::class);
        }
    }
}
