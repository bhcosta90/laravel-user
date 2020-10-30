<?php

namespace BRCas\User\Test\User;

use BRCas\User\Test\TestCase;
use Spatie\Permission\Models\Permission;

class Functions extends TestCase 
{
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
            'name' => 'Teste de Usuário',
            'permissions' => [],
        ]);
    }

    protected function registerPermissions()
    {
        $permissions = ['10', '20', '30', '40'];

        foreach($permissions as $per){
            Permission::create(['name' => $per, 'guard_name' => 'web']);
        }
    }
    
}