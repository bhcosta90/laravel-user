<?php

namespace BRCas\User\Test\User\Service;

use BRCas\User\Test\User\Functions;

class UserTest extends Functions 
{
    public function testCreate(){

        $objUser = $this->registerUser();

        $this->assertDatabaseHas('users', [
            'id' => $objUser->id,
            'name' => $objUser->name,
            'email' => $objUser->email,
        ]);
    }

    public function testEdit(){
        $objService = app(config('user.services.user'));

        $newEmail = time() . $this->faker->email;

        $objService->edit($this->registerUser(), [
            'name' => 'Edição de Usuário',
            'email' => $newEmail,
            'permissions' => [],
            'roles' => [],
        ]);

        $this->assertDatabaseHas('users', [
            'id' => 1,
            'name' => 'Edição de Usuário',
            'email' => $newEmail
        ]);
    }

    public function testDelete(){
        $objService = app(config('user.services.user'));

        $objService->destroy($this->registerUser());

        $this->assertDatabaseMissing('users', [
            'id' => 1,
            'name' => 'Edição de Usuário',
            'email' => 'teste@teste.com.br',
        ]);
    }
    
}