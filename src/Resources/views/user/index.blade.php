@extends(config('bhcosta90-user.template') ?: 'bhcosta90-user::layouts.master')

@section('content')
    <x-card-filter title="Buscar usuário" :filter="$filter" />
    <x-card>
        <x-card-header title="Relatório de usuário" register={{$linkRegister}} text-register="Adicionar usuário" />
        <x-table-list :data="$data" :table="$table" :actions="$actions" />
    </x-card>
@endsection
