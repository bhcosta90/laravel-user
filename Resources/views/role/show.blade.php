@extends(config('bhcosta90-user.template') ?: 'bhcosta90-user::layouts.master')

@section('content')
    <x-card>
        <x-card-header title="Dados do usuário" />
        <table class="table m-0">
            <tbody>
                <tr>
                    <td><strong>{!! __('Nome') !!}</strong></td>
                    <td>{{$obj->name}}</td>
                </tr>
            <tbody>
        </table>
    </x-card>

    <x-card>
        <x-card-header title="Permissões" />
        <x-card-body>{{implode(', ', $obj->permissions()->pluck('name')->toArray())}}</x-card-body>
    </x-card>
@endsection
