<?php


namespace Costa\User\Services\Contracts;


interface UserContract
{
    public function loginFailed($password, $hashPassword): bool;

    public function loginSuccess($password, $hashPassword): bool;

    public function updateMyProfile($id, $data, $nameRoute);

    public function updateMyPassword($id, $password, $nameRoute);

    public function canUpdatePassword(): bool;

    public function getRoles($obj): array;

    public function getPermissions($obj): array;
}
