<x-app-layout>
    <x-slot name="header">
        <h2 class="m-0 text-dark my-2">
            @if(auth()->user()->can(config('costa_user.role.create')))
                <a href="{{route($route_name . '.create')}}" class="btn btn-success">
                    <i class="fa fa-plus"></i>
                </a>
            @endif
            {{ __('Listagem de Grupos') }}
        </h2>

        @if(Breadcrumbs::exists($route_name . '.index'))
            {{ Breadcrumbs::render($route_name . '.index') }}
        @endif
    </x-slot>

    <div class="card card-outline card-gray">
        <div class="card-header">Relatório</div>
        <div class="card-body">
            <form action="{{ route($route_name . '.index') }}" class="form form-inline" method="get">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Nome do Grupo" name="name"
                           value="{{ $filter['name'] ?? '' }}">
                    <div class="input-group-append">
                        <button class="btn btn-success">Pesquisar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card card-outline card-gray">
        <table class="table table-striped my-0 table-hover">
            <thead>
            <th style="width: 1px">#</th>
            <th>{{__('Nome')}}</th>
            <th class="text-right" style="width: 200px">{{__('Ações')}}</th>
            </thead>
            @foreach($data as $rs)
                <tr>
                    <td>{{ $rs->id }}</td>
                    <td>{{ $rs->name }}</td>
                    <td class="text-right">
                        @if(auth()->user()->can(config('costa_user.user.edit')))
                            <a href="{{ route($route_name . '.edit', $rs->id) }}" class="badge badge-warning">Editar</a>
                        @endif

                        @if(auth()->user()->can(config('costa_user.user.show')))
                            <a href="{{ route($route_name . '.show', $rs->id) }}"
                               class="badge badge-secondary">Detalhes</a>
                        @endif

                        @if(auth()->user()->can(config('costa_user.user.destroy')))
                            <form style="display: inline-block" action="{{route($route_name . '.destroy', $rs->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button href="{{ route($route_name . '.show', $rs->id) }}"
                                        class="badge badge-danger">Deletar</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
        <x-paginator :data="$data">{!! $data->links() !!}</x-paginator>
    </div>
</x-app-layout>
