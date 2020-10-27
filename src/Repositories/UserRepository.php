<?php

namespace BRCas\User\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use BRCas\Laravel\Exceptions\CustomException;
use Illuminate\Http\Response;

class UserRepository implements Contracts\UserContract{
    public function index()
    {
        return User::orderName();
    }

    public function find($id)
    {
        return User::find($id);
    }

    public function edit($obj, array $data)
    {
        return $obj->update($data);
    }

    public function create(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return User::create($data);
    }

    public function destroy($obj)
    {
        if(auth()->user() == $obj) throw new CustomException(__('You cannot delete your user'), Response::HTTP_BAD_REQUEST);
        return $obj->delete();
    }
}