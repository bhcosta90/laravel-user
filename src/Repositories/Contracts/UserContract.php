<?php

namespace BRCas\User\Repositories\Contracts;

interface UserContract {
    
    public function index();

    public function find($id);
    
    public function edit($obj, array $data);
    
    public function create(array $data);
    
    public function destroy($obj);
    
}