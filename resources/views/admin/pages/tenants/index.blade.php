@extends('adminlte::page')

@section('title', 'Empresas')

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('tenants.index') }}">Empresas</a></li>
    </ol>
    <h1>Empresas <a href="{{ route('tenants.create') }}" class="btn btn-dark">ADD</a></h1>

@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <form action="{{ route('tenants.search') }}" method="POST" class="form form-inline">
                @csrf
                <input type="text" name="filter" placeholder="Buscar empresa" class="form-control"
                    value={{ $filters['filter'] ?? '' }}>
                <button type="submit" class="btn btn-dark">Buscar</button>
            </form>
        </div>
        <div class="card-body">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>Imagem</th>
                        <th>Nome</th>
                        <th>CNPJ</th>
                        <th>Email</th>
                        <th width="300">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @foreach ($tenants as $tenant)
                            <td>
                                <img src="{{ url("storage/{$tenant->logo}") }}" alt="{{ $tenant->logo }}" style="max-width: 90px;">
                            </td>
                            <td>
                                {{ $tenant->name }}
                            </td>
                            <td>
                                {{ $tenant->cnpj }}
                            </td>
                            <td>
                                {{ $tenant->email }}
                            </td>
                            <td style="width=10px;">
                                <a href="{{ route('tenants.edit', $tenant->id) }}" class="btn btn-info">Editar</a>
                                <a href="{{ route('tenants.show', $tenant->id) }}" class="btn btn-warning">VER</a>
                            </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if (isset($filters))
            {!! $tenants->appends($filters)->links() !!}
        @else
            {!! $tenants->links() !!}
        @endif
    </div>
@stop
