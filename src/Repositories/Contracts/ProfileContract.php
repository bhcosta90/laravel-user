<?php


namespace BRCas\User\Repositories\Contracts;


interface ProfileContract
{
    public function updateProfile($name, $email);

    public function updatePassword($password);
}
