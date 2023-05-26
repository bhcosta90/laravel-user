<?php

namespace BRCas\LaravelUser\Services;

use Illuminate\Database\Eloquent\Model;

class ProfileService
{
    protected Model $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function update($data){
        $this->user->update($data);
        return $this->user;
    }

    public function updatePassword($data){
        $this->user->update([
            'password' => $data['password'],
        ]);
    }
}
