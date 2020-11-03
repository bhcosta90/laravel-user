<?php

namespace BRCas\User\Test\User;

use BRCas\User\Test\TestCase;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\{Permission, Role};

class Functions extends TestCase 
{
    const PERMISSION_1 = [
        'id' => 1,
        'name' => 'PERMISSION | 01',
    ];

    const PERMISSION_2 = [
        'id' => 2,
        'name' => 'PERMISSION | 02',
    ];

    const PERMISSION_3 = [
        'id' => 3,
        'name' => 'PERMISSION | 03',
    ];

    const PERMISSION_4 = [
        'id' => 4,
        'name' => 'PERMISSION | 04',
    ];

    const PERMISSION_5 = [
        'id' => 5,
        'name' => 'PERMISSION | 05',
    ];

    const ROLE_1 = [
        'id' => 1,
        'name' => '01',
    ];

    const ROLE_2 = [
        'id' => 2,
        'name' => '02',
    ];

    const ROLE_3 = [
        'id' => 3,
        'name' => '03',
    ];

    const ROLE_4 = [
        'id' => 4,
        'name' => '04',
    ];

    const ROLE_5 = [
        'id' => 5,
        'name' => '05',
    ];


    protected function registerUser()
    {
        $objService = app(config('user.services.user'));
        
        return $objService->create([
            'password' => '123456789',
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'permissions' => [],
            'roles' => [],
        ]);

    }
    
    protected function registerRole()
    {
        $objService = app(config('user.services.role'));
        
        return $objService->create([
            'name' => 'Teste de Usuario',
            'permissions' => [],
        ]);
    }

    protected function registerAndLoginUser()
    {
        Auth::login($this->registerUser());
    }

    protected function registerPermissions()
    {
        $permissions = [
            self::PERMISSION_1, 
            self::PERMISSION_2, 
            self::PERMISSION_3, 
            self::PERMISSION_4, 
            self::PERMISSION_5
        ];

        foreach($permissions as $per){
            Permission::create(['id' => $per['id'] , 'name' => $per['name'], 'guard_name' => 'web']);
        }
    }

    protected function registerRoles()
    {
        $this->registerPermissions();
        
        $permissions = [
            self::ROLE_1, 
            self::ROLE_2, 
            self::ROLE_3, 
            self::ROLE_4, 
            self::ROLE_5, 
        ];

        foreach($permissions as $per){
            $objGroup = Role::create(['id' => $per['id'] , 'name' => $per['name']]);

            switch($per['id']){
                case self::ROLE_1['id']:
                    $objGroup->permissions()->sync([
                        self::PERMISSION_1['id'],
                        self::PERMISSION_3['id']
                    ]);
                break;
                case self::ROLE_2['id']:
                    $objGroup->permissions()->sync([
                        self::PERMISSION_2['id'],
                        self::PERMISSION_4['id']
                    ]);
                break;
                case self::ROLE_3['id']:
                    $objGroup->permissions()->sync([
                        self::PERMISSION_5['id'],
                    ]);
                break;
            }
        }
    }
    
}