@extends('layouts.app')
@section('content_header')
    <h2 class="m-0 text-dark my-2">
        {{ __('Usuário: ') }}{{ $obj->name }}
    </h2>

    @if(Breadcrumbs::exists($route_name . '.show'))
        {{ Breadcrumbs::render('admin.users.users.show', $obj) }}
    @endif

@endsection
@section('content')

    <div class="card card-outline card-gray">
        <div class="card-header">{{ __('Usuário: ') }}{{ $obj->name }}</div>
        <div class="card-body">
            @if(config('costa_user.router.user') == 'id')
                <p><strong>{{ __('ID') }}: </strong>{{ $obj->id }}</p>
            @endif
            <p><strong>{{ __('Nome') }}: </strong>{{ $obj->name }}</p>
            <p><strong>{{ __('E-mail') }}: </strong>{{ $obj->email }}</p>

            @if(auth()->user()->can(config('costa_user.permissions.user.destroy')))
                @php $key = config('costa_user.router.user'); @endphp
                <hr/>

                <form action="{{route($route_name . '.destroy', $obj->$key)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">{{ __('Deletar') }}</button>
                </form>
            @endif
        </div>
    </div>
@endsection
