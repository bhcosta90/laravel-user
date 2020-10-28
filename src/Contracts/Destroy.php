<?php

namespace BRCas\User\Contracts;

interface Destroy
{
    public function find($id);

    public function destroy($obj);
}
