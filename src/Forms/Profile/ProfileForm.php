<?php

namespace BRCas\User\Forms\Profile;

use Kris\LaravelFormBuilder\{Field, Form};

class ProfileForm extends Form
{
    public function buildForm()
    {
        $id = auth()->user()->id;

        $this
            ->add('name', Field::TEXT, [
                'label' => __('Name'),
                'rules' => 'required|min:5'
            ])
            ->add('email', Field::EMAIL, [
                'label' => __('Email'),
                'rules' => "required|email|min:5|unique:users,email,{$id},id"
            ])
            ->add('password', Field::PASSWORD, [
                'label' => __('Password'),
                'rules' => 'required|min:6|max:16'
            ]);
    }
}
