<?php

namespace BRCas\User\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;

class UserForm extends Form {
    public function buildForm()
    {
        $id = $this->request->route('user');
        
        $this
            ->add('name', Field::TEXT, [
                'label' => __('Name'),
                'rules' => 'required|min:5'
            ])
            ->add('email', Field::EMAIL, [
                'label' => __('Email'),
                'rules' => "required|email|min:5|unique:users,email,{$id},id"
            ]);

        if(empty($this->request->route('user'))){
            $this->add('password', Field::PASSWORD, [
                'label' => __('Password'),
                'rules' => 'required|min:6|max:16'
            ]);
        }
    }
}