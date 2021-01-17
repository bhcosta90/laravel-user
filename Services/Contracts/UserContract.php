<?php


namespace Costa\User\Services\Contracts;


interface UserContract
{
    public function all();

    public function show($id);

    public function create(array $data);

    public function update($id, $data);

    public function delete($id);

    public function myProfile();

    public function updateMyProfile($data);

    public function updateMyPassword($data);

    public function getRoles($obj);

    public function getPermissions($obj);
}
