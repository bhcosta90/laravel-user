<?php

namespace BRCas\User\Test\User\Service;

use BRCas\User\Test\User\Functions;

class RoleTest extends Functions 
{
    public function testCreate(){

        $objUser = $this->registerRole();

        $this->assertDatabaseHas(config('permission.table_names.roles'), [
            'name' => $objUser->name,
        ]);
    }

    public function testEdit(){
        $objService = app(config('user.services.role'));

        $objService->edit($this->registerRole(), [
            'name' => 'Edicao de Usuario',
            'permissions' => [],
        ]);

        $this->assertDatabaseHas(config('permission.table_names.roles'), [
            'id' => 1,
            'name' => 'Edicao de Usuario',
        ]);
    }

    public function testDelete(){
        $objService = app(config('user.services.user'));

        $objService->destroy($this->registerRole());

        $this->assertDatabaseMissing(config('permission.table_names.roles'), [
            'id' => 1,
            'name' => 'Edicao de Usuario',
            'email' => 'teste@teste.com.br',
        ]);
    }
    
}