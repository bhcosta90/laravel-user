@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">{{__('Cadastrar novo usuário')}}</div>
        <div class="card-body">
            {!! form_start($form) !!}
            <div class="row">
                <div class="col-6">
                    {!! form_row($form->name) !!}
                </div>
                <div class="col-6">
                    {!! form_row($form->email) !!}
                </div>
            </div>
            {!! form_end($form) !!}
        </div>
    </div>
@endsection
