@extends(config('bhcosta90-user.template') ?: 'bhcosta90-user::layouts.master')

@section('content')
    <x-card>
        <x-card-header title="Editar usuário" />
        <x-card-body>{!! form($form) !!}</x-card-body>
    </x-card>
@endsection
