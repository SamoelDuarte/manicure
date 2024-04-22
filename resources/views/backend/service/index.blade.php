@extends('layouts.app')
@section('title', 'Agenda')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Serviços</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Valor</th>
                                <th>Tempo</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($servicos as $servico)
                            <tr>
                                <td>{{ $servico->nome }}</td>
                                <td>{{ $servico->valor }}</td>
                                <td>{{ $servico->tempo }}</td>
                                <td>
                                    <a href="{{ route('servicos.edit', $servico->id) }}" class="btn btn-primary">Editar</a>
                                    <form action="{{ route('servicos.destroy', $servico->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este serviço?')">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{ route('servicos.create') }}" class="btn btn-success">Novo Serviço</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


