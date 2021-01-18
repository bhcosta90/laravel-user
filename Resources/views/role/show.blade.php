@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">{{__('Detalhe do usuário')}}</div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <label>{{__('Nome')}}</label>
                    <div>{{$rs->name}}</div>
                </div>
                <div class="col-6">
                    <label>{{__('Email')}}</label>
                    <div><a href="mailto:{{$rs->email}}">{{$rs->email}}</a></div>
                </div>
            </div>
        </div>
    </div>
@endsection
