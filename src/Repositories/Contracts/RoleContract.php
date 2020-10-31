<?php

namespace BRCas\User\Repositories\Contracts;

interface RoleContract
{
    public function index();

    public function create($data);

    public function find($id);

    public function edit($obj, $data);

    public function destroy($obj);

    public function getPermissions($obj): array;
}
