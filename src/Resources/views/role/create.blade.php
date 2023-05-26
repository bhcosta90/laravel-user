@extends(config('bhcosta90-user.template') ?: 'bhcosta90-user::layouts.master')

@section('content')
    <x-card>
        <x-card-header title="{{config('bhcosta90-user.role.new')}}" />
        <x-card-body>
            {!! form_start($form) !!}
            {!! form_row($form->name) !!}
            <x-permission :model="config('permission.models.role')" :permissions="$permissions" :my-permissions="$modelHasPermission" />
            {!! form_end($form) !!}
        </x-card-body>
    </x-card>
@endsection
