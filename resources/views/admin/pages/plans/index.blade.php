@extends('adminlte::page')

@section('title', 'Planos')

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('plans.index') }}">Planos</a></li>
    </ol>
    <h1>Planos <a href="{{ route('plans.create') }}" class="btn btn-dark">ADD</a></h1>

@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <form action="{{ route('plans.search') }}" method="POST" class="form form-inline">
                @csrf
                <input type="text" name="filter" placeholder="Buscar produto" class="form-control"
                    value={{ $filters['filter'] ?? '' }}>
                <button type="submit" class="btn btn-dark">Buscar</button>
            </form>
        </div>
        <div class="card-body">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Preço</th>
                        <th width="300">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @foreach ($plans as $plan)
                            <td>
                                {{ $plan->name }}
                            </td>
                            <td>
                                R$ {{ $plan->price }}
                            </td>
                            <td style="width=10px;">
                                <a href="{{route('details.plans.index', $plan->url)}}" class="btn btn-info">Detalhes</a>
                                <a href="{{ route('plans.edit', $plan->url) }}" class="btn btn-info">Editar</a>
                                <a href="{{ route('plans.show', $plan->url) }}" class="btn btn-warning">VER</a>
                                <a href="{{ route('plans.profiles', $plan->id) }}" class="btn btn-warning"><i class="fas fa-address-book"></i></a>
                            </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if (isset($filters))
            {!! $plans->appends($filters)->links() !!}
        @else
            {!! $plans->links() !!}
        @endif
    </div>
@stop
