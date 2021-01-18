@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">{{__('Cadastrar novo grupo')}}</div>
        <div class="card-body">
            {!! form_start($form) !!}
            {!! form_end($form) !!}
        </div>
    </div>
@endsection
