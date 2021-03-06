@extends('layouts.app')
@section('content_header')
    <h2 class="m-0 text-dark my-2">
        @if(auth()->user()->can(config('costa_user.permissions.role.create')))
            <a href="{{route($route_name . '.create')}}" class="btn btn-success">
                <i class="fa fa-plus"></i>
            </a>
        @endif
        {{ __('Listagem de Grupos') }}
    </h2>

    @if(Breadcrumbs::exists($route_name . '.index'))
        {{ Breadcrumbs::render($route_name . '.index') }}
    @endif
@endsection
@section('content')

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
            @if(config('costa_user.router.role') == 'id')
                <th style="width: 1px">#</th>
            @endif
            <th>{{__('Nome')}}</th>
            <th class="text-right" style="width: 200px">{{__('Ações')}}</th>
            </thead>
            @foreach($data as $rs)
                @php $key = config('costa_user.router.role'); @endphp
                <tr>
                    @if(config('costa_user.router.role') == 'id')
                        <td>{{ $rs->id }}</td>
                    @endif
                    <td>{{ $rs->name }}</td>
                    <td class="text-right">
                        @if(auth()->user()->can(config('costa_user.permissions.role.edit')))
                            <a href="{{ route($route_name . '.edit', $rs->$key) }}" class="badge badge-warning">Editar</a>
                        @endif

                        @if(auth()->user()->can(config('costa_user.permissions.role.show')))
                            <a href="{{ route($route_name . '.show', $rs->$key) }}"
                               class="badge badge-secondary">Detalhes</a>
                        @endif

                        @if(auth()->user()->can(config('costa_user.permissions.role.destroy')))
                            <form style="display: inline-block" action="{{route($route_name . '.destroy', $rs->$key)}}"
                                  method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="badge badge-danger" style="border:0">Deletar</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
        <x-paginator :data="$data">{!! $data->links() !!}</x-paginator>
    </div>
@endsection
