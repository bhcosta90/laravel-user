@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">{{__('Relatório de usuário')}}</div>
        <div class="card-body">
            @if (Session::has('success') && Session::get("success"))
                <div class="alert-flash alert alert-success mt-3 text-center" role="alert">
                    {!! Session::get("success") !!}
                </div>
            @endif

            {{$results}}
        </div>
    </div>
@endsection
