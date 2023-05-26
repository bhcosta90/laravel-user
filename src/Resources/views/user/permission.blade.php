@extends(config('bhcosta90-user.template') ?: 'bhcosta90-user::layouts.master')

@section('content')
    <x-permission :save="$action" :model="$model" :permissions="$permissions" :my-permissions="$modelHasPermission" />
@endsection
