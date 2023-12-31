@extends('adminlte::page')

@section('title', "Detalhes do perfil {$permission->name}")

@section('content_header')
    <h1>Detalhes do perfil <b>{{ $permission->name }}</b></h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <ul>
                <li>
                    <strong>Nome: </strong> {{ $permission->name }}
                </li>
                <li>
                    <strong>Descrição: </strong> {{ $permission->description }}
                </li>
            </ul>

            @include('admin.includes.alerts')

            <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> DELETAR O PERFIL: {{ $permission->name }}</button>
            </form>
        </div>
    </div>
@endsection
