<?php

namespace BRCas\User\Test\User\Requests;

use BRCas\Laravel\Tests\TestDelete;
use BRCas\Laravel\Tests\TestSaves;
use BRCas\User\Models\User;
use BRCas\User\Test\User\Functions;

class UserTest extends Functions {
    
    use TestSaves, TestDelete;

    private $user;

    function setUp(): void
    {
        parent::setUp();
        $this->user = $this->registerUser();
    }

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

    public function testDeleteUser()
    {
        $this->registerAndLoginUser();
        $this->assertDelete($this->user->id);
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
        return route('admin.users.users.update', $this->user->id);
    }

    protected function routeDelete()
    {
        return route('admin.users.users.update', $this->user->id);
    }


}