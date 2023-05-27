@extends(config('bhcosta90-user.template') ?: 'bhcosta90-user::layouts.master')

@section('content')
    <x-card>
        <x-card-header title="{{config('bhcosta90-user.user.view.create')}}" />
        <x-card-body>
            {!! form_start($form) !!}
            {!! form_row($form->name) !!}
            {!! form_row($form->email) !!}
            {!! form_row($form->password) !!}
            {!! form_end($form) !!}
        </x-card-body>
    </x-card>
@endsection
