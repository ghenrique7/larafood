@extends('adminlte::page')

@section('title', "Detalhes do Plano {$plan->name}")

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('plans.index') }}">Planos</a></li>
        <li class="breadcrumb-item"><a href="{{ route('plans.show', $plan->url) }}">{{ $plan->name }}</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('details.plans.index', $plan->url) }}">Detalhes</a></li>
    </ol>
    <h1>Detalhes do plano {{ $plan->name }} <a href="{{ route('details.plans.create', $plan->url) }}"
            class="btn btn-dark">ADD</a></h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">

            @include('admin.includes.alerts')

            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th width="150">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @foreach ($details as $detail)
                            <td>
                                {{ $detail->name }}
                            </td>
                            <td style="width=10px;">
                                <a href="{{ route('details.plans.edit', [$plan->url, $detail->id]) }}"
                                    class="btn btn-info">Editar</a>
                                <a href="{{ route('details.plans.show', [$plan->url, $detail->id]) }}"
                                    class="btn btn-warning">VER</a>
                            </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if (isset($filters))
            {!! $details->appends($filters)->links() !!}
        @else
            {!! $details->links() !!}
        @endif
    </div>
@stop
