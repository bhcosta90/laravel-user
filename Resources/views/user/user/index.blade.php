<x-app-layout>
    <x-slot name="header">
        <h2 class="m-0 text-dark my-2">
            <a href="{{route($route_name . '.create')}}" class="btn btn-success">
                <i class="fa fa-plus"></i>
            </a>
            {{ __('Listagem de Usuários') }}
        </h2>

        @if(Breadcrumbs::exists($route_name . '.index'))
            {{ Breadcrumbs::render($route_name . '.index') }}
        @endif
    </x-slot>

    <div class="card">
        <div class="card-header">Relatório</div>
        <div class="card-body">
            <form action="{{ route($route_name . '.index') }}" class="form form-inline" method="get">
                <input type="text" class="form-control" placeholder="Nome do Usuário" name="name"
                       value="{{ $filter['name'] ?? '' }}">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Email do Usuário" name="email"
                           value="{{ $filter['email'] ?? '' }}">
                    <div class="input-group-append">
                        <button class="btn btn-success">Pesquisar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <table class="table table-striped my-0 table-hover">
            <thead>
            <th style="width: 1px">#</th>
            <th>{{__('Nome')}}</th>
            <th>{{__('E-mail')}}</th>
            <th class="text-right" style="width: 150px">{{__('Ações')}}</th>
            </thead>
            @foreach($data as $rs)
                <tr>
                    <td>{{ $rs->id }}</td>
                    <td>{{ $rs->name }}</td>
                    <td>{{ $rs->email }}</td>
                    <td class="text-right">
                        <a href="{{ route($route_name . '.edit', $rs->id) }}" class="badge badge-warning">Editar</a>

                        <a href="{{ route($route_name . '.show', $rs->id) }}"
                           class="badge badge-secondary">Detalhes</a>
                    </td>
                </tr>
            @endforeach
        </table>
        <x-paginator :data="$data">{!! $data->links() !!}</x-paginator>
    </div>
</x-app-layout>
