@extends('adminlte::page')

@section('title', 'Usuários')

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('users.index') }}">Usuários</a></li>
    </ol>
    <h1>Usuários <a href="{{ route('users.create') }}" class="btn btn-dark">ADD</a></h1>

@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <form action="{{ route('users.search') }}" method="POST" class="form form-inline">
                @csrf
                <input type="text" name="filter" placeholder="Buscar usuario" class="form-control"
                    value={{ $filters['filter'] ?? '' }}>
                <button type="submit" class="btn btn-dark">Buscar</button>
            </form>
        </div>
        <div class="card-body">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th width="300">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @foreach ($users as $user)
                            <td>
                                {{ $user->name }}
                            </td>
                            <td>
                                {{ $user->email }}
                            </td>
                            <td style="width=10px;">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-info">Editar</a>
                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-warning">VER</a>
                                <a href="{{ route('users.roles', $user->id) }}" class="btn btn-warning"><i class="fas fa-tasks"></i></a>
                    @endforeach
            </table>
        </div>
        @if (isset($filters))
            {!! $users->appends($filters)->links() !!}
        @else
            {!! $users->links() !!}
        @endif
    </div>
@stop
