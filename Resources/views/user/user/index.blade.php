@extends('layouts.app')
@section('content_header')
    <h2 class="m-0 text-dark my-2">
        @if(auth()->user()->can(config('costa_user.user.create')))
            <a href="{{route($route_name . '.create')}}" class="btn btn-success">
                <i class="fa fa-plus"></i>
            </a>
        @endif
        {{ __('Listagem de Usuários') }}
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
                <input type="text" class="form-control mr-3" placeholder="Nome do Usuário" name="name"
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
    <div class="card card-outline card-gray">
        <table class="table table-striped my-0 table-hover">
            <thead>
            <th style="width: 1px">#</th>
            <th>{{__('Nome')}}</th>
            <th>{{__('E-mail')}}</th>
            <th class="text-right" style="width: 200px">{{__('Ações')}}</th>
            </thead>
            @foreach($data as $rs)
                <tr>
                    <td>{{ $rs->id }}</td>
                    <td>{{ $rs->name }}</td>
                    <td>{{ $rs->email }}</td>
                    <td class="text-right">
                        @if(auth()->user()->can(config('costa_user.user.edit')))
                            <a href="{{ route($route_name . '.edit', $rs->id) }}" class="badge badge-warning">Editar</a>
                        @endif

                        @if(auth()->user()->can(config('costa_user.user.show')))
                            <a href="{{ route($route_name . '.show', $rs->id) }}"
                               class="badge badge-secondary">Detalhes</a>
                        @endif

                        @if(auth()->user()->can(config('costa_user.user.destroy')))
                            <form style="display: inline-block" action="{{route($route_name . '.destroy', $rs->id)}}"
                                  method="POST">
                                @csrf
                                @method('DELETE')
                                <button href="{{ route($route_name . '.show', $rs->id) }}"
                                        class="badge badge-danger" style="border:0">Deletar
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
        <x-paginator :data="$data">{!! $data->links() !!}</x-paginator>
    </div>
@endsection
