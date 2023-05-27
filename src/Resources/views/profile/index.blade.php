@extends(config('bhcosta90-user.template') ?: 'bhcosta90-user::layouts.master')

@section('content')
    <x-card>
        <x-card-header title="{{config('bhcosta90-user.profile.view.profile')}}" />
        <x-card-body>
            {!! form($form) !!}
        </x-card-body>
    </x-card>

    <x-card>
        <x-card-header title="{{config('bhcosta90-user.profile.view.password')}}" />
        <x-card-body>
            {!! form($password) !!}
        </x-card-body>
    </x-card>
@endsection
