@extends(config('bhcosta90-user.template') ?: 'bhcosta90-user::layouts.master')

@section('content')
    <x-card-filter title="{{config('bhcosta90-user.role.filter')}}" :filter="$filter" />
    <x-card>
        <x-card-header title="{{config('bhcosta90-user.role.title')}}" register={{$linkRegister}} text-register="Adicionar grupo de acesso" />
        <x-table-list :data="$data" :table="$table" :actions="$actions" />
    </x-card>
@endsection
