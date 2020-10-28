<?php

namespace BRCas\User\Contracts;

interface Edit
{
    public function find($id);

    public function edit($obj, array $data);
}
