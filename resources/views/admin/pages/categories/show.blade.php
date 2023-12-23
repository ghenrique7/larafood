@extends('adminlte::page')

@section('title', "Detalhes da Categoria {$category->name}")id

@section('content_header')
    <h1>Detalhes da Categoria <b>{{ $category->name }}</b></h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <ul>
                <li>
                    <strong>Nome: </strong> {{ $category->name }}
                </li>
                <li>
                    <strong>Email: </strong> {{ $category->email }}
                </li>
                <li>
                    <strong>Empresa: </strong> {{ $category->tenant->name }}
                </li>
            </ul>

            @include('admin.includes.alerts')


            <form action="{{ route('categories.destroy', $category->id) }}" class="form" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">DELETAR A CATEGORIA {{ $category->name }}</button>
            </form>
        </div>
    </div>
@endsection
