<?php

namespace BRCas\User\Test\User\Service;

use BRCas\User\Test\User\Functions;

class UserRoleTest extends Functions 
{

    public function testUserRole()
    {

        $objService = app(config('user.services.user'));
        $this->registerRoles();
        
        $objUser = $objService->create([
            'password' => '123456789',
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'permissions' => [],
            'roles' => [self::ROLE_1['id'], self::ROLE_3['id']],
        ]);


        $this->assertDatabaseHas(config('permission.table_names.model_has_roles'), [
            'role_id' => self::ROLE_1['id'],
            'model_type' => config('user.model.user'),
            'model_id' => $objUser->id,
        ]);

        $this->assertDatabaseMissing(config('permission.table_names.model_has_roles'), [
            'role_id' => self::ROLE_2['id'],
            'model_type' => config('user.model.user'),
            'model_id' => $objUser->id,
        ]);

        $this->assertDatabaseHas(config('permission.table_names.model_has_roles'), [
            'role_id' => self::ROLE_3['id'],
            'model_type' => config('user.model.user'),
            'model_id' => $objUser->id,
        ]);

        $this->assertDatabaseMissing(config('permission.table_names.model_has_roles'), [
            'permission_id' => self::ROLE_4['id'],
            'model_type' => config('user.model.user'),
            'model_id' => $objUser->id,
        ]);
    }
}