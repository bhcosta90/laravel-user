@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">{{__('Relatório de usuário')}}</div>
        <div class="card-body">
            {{$results}}
        </div>
    </div>
@endsection
