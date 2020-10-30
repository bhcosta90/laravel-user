<?php

namespace BRCas\User\Test\User\Service;

use BRCas\User\Test\User\Functions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function testUserPermission()
    {

        $objService = app(config('user.services.user'));
        $this->registerPermissions();
        
        $objUser = $objService->create([
            'password' => '123456789',
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'permissions' => [1, 2, 3],
            'roles' => [],
        ]);


        $this->assertDatabaseHas(config('permission.table_names.model_has_permissions'), [
            'permission_id' => 1,
            'model_type' => config('user.model.user'),
            'model_id' => $objUser->id,
        ]);

        $this->assertDatabaseHas(config('permission.table_names.model_has_permissions'), [
            'permission_id' => 2,
            'model_type' => config('user.model.user'),
            'model_id' => $objUser->id,
        ]);

        $this->assertDatabaseHas(config('permission.table_names.model_has_permissions'), [
            'permission_id' => 3,
            'model_type' => config('user.model.user'),
            'model_id' => $objUser->id,
        ]);

        $this->assertDatabaseMissing(config('permission.table_names.model_has_permissions'), [
            'permission_id' => 4,
            'model_type' => config('user.model.user'),
            'model_id' => $objUser->id,
        ]);
    }



    public function testCreatetUserThanIDontHavePermission()
    {

        $objService = app(config('user.services.user'));
        $this->registerPermissions();
        $this->registerUser();
        
        $objUser = $objService->create([
            'password' => '123456789',
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'permissions' => [1, 2, 3],
            'roles' => [],
        ]);

        $objUser2 = $objService->create([
            'password' => '123456789',
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'permissions' => [1, 2, 3, 4],
            'roles' => [],
        ], $objUser);


        $this->assertDatabaseHas(config('permission.table_names.model_has_permissions'), [
            'permission_id' => 1,
            'model_type' => config('user.model.user'),
            'model_id' => $objUser2->id,
        ]);

        $this->assertDatabaseHas(config('permission.table_names.model_has_permissions'), [
            'permission_id' => 2,
            'model_type' => config('user.model.user'),
            'model_id' => $objUser2->id,
        ]);

        $this->assertDatabaseHas(config('permission.table_names.model_has_permissions'), [
            'permission_id' => 3,
            'model_type' => config('user.model.user'),
            'model_id' => $objUser2->id,
        ]);

        $this->assertDatabaseMissing(config('permission.table_names.model_has_permissions'), [
            'permission_id' => 4,
            'model_type' => config('user.model.user'),
            'model_id' => $objUser2->id,
        ]);
    }
    
}