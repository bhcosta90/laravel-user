<?php


namespace Costa\User\Services\Contracts;


interface RoleContract
{
    public function all();

    public function show($id);

    public function create(array $data);

    public function update($id, $data);

    public function delete($id);
}
