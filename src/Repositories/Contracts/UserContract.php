<?php

namespace BRCas\User\Repositories\Contracts;

interface UserContract
{

    public function index();

    public function find($id);

    public function edit($obj, array $data);

    public function create(array $data);

    public function destroy($obj);

    public function registerPermissions($obj, array $permissions);

    public function registerRoles($obj, array $groups);

    public function getPermissions($obj): array;

    public function getRoles($obj): array;

}