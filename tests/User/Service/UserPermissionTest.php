<?php

namespace BRCas\User\Test\User\Service;

use BRCas\User\Test\User\Functions;

class UserPermissionTest extends Functions 
{

    public function testUserPermission()
    {

        $objService = app(config('user.services.user'));
        $this->registerPermissions();
        
        $objUser = $objService->create([
            'password' => '123456789',
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'permissions' => [self::PERMISSION_1['id'], self::PERMISSION_2['id'], self::PERMISSION_3['id']],
            'roles' => [],
        ]);


        $this->assertDatabaseHas(config('permission.table_names.model_has_permissions'), [
            'permission_id' => self::PERMISSION_1['id'],
            'model_type' => config('user.model.user'),
            'model_id' => $objUser->id,
        ]);

        $this->assertDatabaseHas(config('permission.table_names.model_has_permissions'), [
            'permission_id' => self::PERMISSION_2['id'],
            'model_type' => config('user.model.user'),
            'model_id' => $objUser->id,
        ]);

        $this->assertDatabaseHas(config('permission.table_names.model_has_permissions'), [
            'permission_id' => self::PERMISSION_3['id'],
            'model_type' => config('user.model.user'),
            'model_id' => $objUser->id,
        ]);

        $this->assertDatabaseMissing(config('permission.table_names.model_has_permissions'), [
            'permission_id' => self::PERMISSION_4['id'],
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
            'permissions' => [self::PERMISSION_1['id'], self::PERMISSION_2['id'], self::PERMISSION_3['id'], self::PERMISSION_5['id']],
            'roles' => [],
        ]);

        $objUser2 = $objService->create([
            'password' => '123456789',
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'permissions' => [self::PERMISSION_1['id'], self::PERMISSION_2['id'], self::PERMISSION_3['id'], self::PERMISSION_4['id']],
            'roles' => [],
        ], $objUser);


        $this->assertDatabaseHas(config('permission.table_names.model_has_permissions'), [
            'permission_id' => self::PERMISSION_1['id'],
            'model_type' => config('user.model.user'),
            'model_id' => $objUser2->id,
        ]);

        $this->assertDatabaseHas(config('permission.table_names.model_has_permissions'), [
            'permission_id' => self::PERMISSION_2['id'],
            'model_type' => config('user.model.user'),
            'model_id' => $objUser2->id,
        ]);

        $this->assertDatabaseHas(config('permission.table_names.model_has_permissions'), [
            'permission_id' => self::PERMISSION_3['id'],
            'model_type' => config('user.model.user'),
            'model_id' => $objUser2->id,
        ]);

        $this->assertDatabaseMissing(config('permission.table_names.model_has_permissions'), [
            'permission_id' => self::PERMISSION_4['id'],
            'model_type' => config('user.model.user'),
            'model_id' => $objUser2->id,
        ]);
    }

    public function testCreatetUserThanIDontHavePermissionButICan()
    {
        $this->app['config']->set('user.permissions.user.permission', self::PERMISSION_5['name']);

        $objService = app(config('user.services.user'));
        $this->registerPermissions();
        $this->registerUser();
        
        $objUser = $objService->create([
            'password' => '123456789',
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'permissions' => [self::PERMISSION_1['id'], self::PERMISSION_2['id'], self::PERMISSION_3['id'], self::PERMISSION_5['id']],
            'roles' => [],
        ]);

        $objUser2 = $objService->create([
            'password' => '123456789',
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'permissions' => [self::PERMISSION_1['id'], self::PERMISSION_2['id'], self::PERMISSION_3['id'], self::PERMISSION_4['id']],
            'roles' => [],
        ], $objUser);


        $this->assertDatabaseHas(config('permission.table_names.model_has_permissions'), [
            'permission_id' => self::PERMISSION_1['id'],
            'model_type' => config('user.model.user'),
            'model_id' => $objUser2->id,
        ]);

        $this->assertDatabaseHas(config('permission.table_names.model_has_permissions'), [
            'permission_id' => self::PERMISSION_2['id'],
            'model_type' => config('user.model.user'),
            'model_id' => $objUser2->id,
        ]);

        $this->assertDatabaseHas(config('permission.table_names.model_has_permissions'), [
            'permission_id' => self::PERMISSION_3['id'],
            'model_type' => config('user.model.user'),
            'model_id' => $objUser2->id,
        ]);

        $this->assertDatabaseHas(config('permission.table_names.model_has_permissions'), [
            'permission_id' => self::PERMISSION_4['id'],
            'model_type' => config('user.model.user'),
            'model_id' => $objUser2->id,
        ]);
    }
}