@extends('adminlte::page')

@section('title', "Detalhes do Produto {$product->name}")

@section('content_header')
    <h1>Detalhes do Produto <b>{{ $product->name }}</b></h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <ul>
                <li>
                    <img src="{{ url("storage/{$product->image}") }}" alt="{{ $product->image }}" style="max-width: 90px;">
                </li>
                <li>
                    <strong>Nome: </strong> {{ $product->title }}
                </li>
                <li>
                    <strong>Flag: </strong> {{ $product->flag }}
                </li>
                <li>
                    <strong>Descirção: </strong> {{ $product->description }}
                </li>
            </ul>

            @include('admin.includes.alerts')


            <form action="{{ route('products.destroy', $product->id) }}" class="form" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">DELETAR A CATEGORIA {{ $product->name }}</button>
            </form>
        </div>
    </div>
@endsection
