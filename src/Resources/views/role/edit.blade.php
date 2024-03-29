@extends(config('bhcosta90-user.template') ?: 'bhcosta90-user::layouts.master')

@section('content')
    <x-card>
        <x-card-header title="{{config('bhcosta90-user.role.view.edit')}}" />
        <x-card-body>
            {!! form_start($form) !!}
            {!! form_row($form->name) !!}
            <x-permission fieldset=1 :model="config('permission.models.role')" :permissions="$permissions" :my-permissions="$modelHasPermission" />
            {!! form_end($form) !!}
        </x-card-body>
    </x-card>
@endsection
