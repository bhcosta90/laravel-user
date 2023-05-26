@extends(config('bhcosta90-user.template') ?: 'bhcosta90-user::layouts.master')

@section('content')
    <x-card>
        <x-card-header title="Dados do usuário" />
        <table class="table m-0">
            <tbody>
                <tr>
                    <td><strong>{!! __('E-Mail Address') !!}</strong></td>
                    <td>{{$obj->email}}</td>
                </tr>
            <tbody>
        </table>
    </x-card>
@endsection
