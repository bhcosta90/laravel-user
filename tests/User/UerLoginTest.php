<?php

namespace BRCas\User\Tests;

use BRCas\Laravel\Tests\TestSaves;
use BRCas\User\Models\User;
use BRCas\User\Test\TestCase;

class UerLoginTest extends TestCase{
    
    use TestSaves;

    public function testRegisterNewUser()
    {
        $this->registerAndLoginUser();        
        
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->companyEmail,
            'password' => "123456",
            'permissions' => [],
            'roles' => [],
        ];

        $this->assertStore($data, [
            'name' => $data['name'],
            'email' => $data['email'],
        ], [
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
    }

    public function testEditUser()
    {
        $this->registerAndLoginUser();
        
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->companyEmail,
            'permissions' => [],
            'roles' => [],
        ];
        
        $this->assertUpdate($data, [
            'name' => $data['name'],
            'email' => $data['email'],
        ], [
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
    }

    public function model()
    {
        return User::class;
    }

    public function routeStorage()
    {
        return route('admin.users.users.store');
    }

    public function routeUpdate()
    {
        $objUser = $this->registerUser();
        return route('admin.users.users.update', $objUser->id);
    }
}