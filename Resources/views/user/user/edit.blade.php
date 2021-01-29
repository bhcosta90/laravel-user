@extends('layouts.app')
@section('content_header')
    <h2 class="m-0 text-dark my-2">
        {{ __('Editar Usuário: ') }} {{ $form->getModel()->name }}
    </h2>

    @if(Breadcrumbs::exists($route_name . '.edit'))
        {{ Breadcrumbs::render($route_name . '.edit', $form->getModel()) }}
    @endif
@endsection
@section('content')
    <div class="card card-outline card-gray">
        <div class="card-header">{{ __('Editar Usuário: ') }} {{ $form->getModel()->name }}</div>
        <div class="card-body">
            {!! form($form) !!}
        </div>
    </div>
@endsection
