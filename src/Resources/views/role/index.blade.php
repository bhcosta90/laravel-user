@extends(config('bhcosta90-user.template') ?: 'bhcosta90-user::layouts.master')

@section('content')
    <x-card-filter title="{{config('bhcosta90-user.role.view.search')}}" :filter="$filter" />
    <x-card>
        <x-card-header title="{{config('bhcosta90-user.role.view.index')}}" register={{$register}} text-register="{{config('bhcosta90-user.role.view.register')}}" />
        <x-table-list :data="$data" :table="$table" :actions="$actions" />
    </x-card>
@endsection
