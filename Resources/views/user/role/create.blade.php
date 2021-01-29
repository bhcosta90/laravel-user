<x-app-layout>
    <x-slot name="header">
        <h2 class="m-0 text-dark my-2">
            {{ __('Cadastro de Grupo') }}
        </h2>

        @if(Breadcrumbs::exists($route_name . '.create'))
            {{ Breadcrumbs::render($route_name . '.create') }}
        @endif

    </x-slot>

    <div class="card card-outline card-gray">
        <div class="card-header">Cadastrar Grupo</div>
        <div class="card-body">
            {!! form($form) !!}
        </div>
    </div>
</x-app-layout>
