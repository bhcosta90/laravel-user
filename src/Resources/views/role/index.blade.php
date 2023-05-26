@extends(config('bhcosta90-user.template') ?: 'bhcosta90-user::layouts.master')

@section('content')
    <x-card-filter title="Buscar grupo de acesso" :filter="$filter" />
    <x-card>
        <x-card-header title="Relatório de grupo de acesso" register={{$linkRegister}} text-register="Adicionar grupo de acesso" />
        <x-table-list :data="$data" :table="$table" :actions="$actions" />
    </x-card>
@endsection
