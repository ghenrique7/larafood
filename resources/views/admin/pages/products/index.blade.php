@extends('adminlte::page')

@section('title', 'Produtos')

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('products.index') }}">Produtos</a></li>
    </ol>
    <h1>Produtos <a href="{{ route('products.create') }}" class="btn btn-dark">ADD</a></h1>

@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <form action="{{ route('products.search') }}" method="POST" class="form form-inline">
                @csrf
                <input type="text" name="filter" placeholder="Buscar categoria" class="form-control"
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
                        <th>Descrição</th>
                        <th>Preço</th>
                        <th>Bandeira</th>
                        <th width="300">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @foreach ($products as $product)
                            <td>
                                <img src="{{ url("storage/{$product->image}") }}" alt="{{ $product->image }}" style="max-width: 90px;">
                            </td>
                            <td>
                                {{ $product->title }}
                            </td>
                            <td>
                                {{ $product->description }}
                            </td>
                            <td>
                                {{ $product->price }}
                            </td>
                            <td>
                                {{ $product->flag }}
                            </td>
                            <td style="width=10px;">
                                <a href="{{ route('products.categories', $product->id) }}" class="btn btn-warning"><i class="fas fa-layer-group"></i></a>
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-info">Editar</a>
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-warning">VER</a>
                            </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if (isset($filters))
            {!! $products->appends($filters)->links() !!}
        @else
            {!! $products->links() !!}
        @endif
    </div>
@stop
