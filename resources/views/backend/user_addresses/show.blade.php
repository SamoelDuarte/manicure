@extends('layouts.admin')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">
                {{ $userAddress->title }}
            </h6>
            <div class="ml-auto">
                <a href="{{ back()->getTargetUrl() }}" class="btn btn-primary">
                    <span class="text">Voltar para a página anterior</span>
                </a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Usuário</th>
                    <th>CEP</th>
                    <th>Endereço</th>
                    <th>Bairro</th>
                    <th>Cidade</th>
                    <th>Estado</th>
                    <th>Número</th>
                    <th>Complemento</th>
                    <th>Data</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{ $userAddress->user->first_name }}</td>
                    <td>{{ $userAddress->zipcode }}</td>
                    <td>{{ $userAddress->address }}</td>
                    <td>{{ $userAddress->neighborhood }}</td>
                    <td>{{ $userAddress->city }}</td>
                    <td>{{ $userAddress->state }}</td>
                    <td>{{ $userAddress->number }}</td>
                    <td>{{ $userAddress->complement }}</td>
                    <td>{{ $userAddress->created_at->format('d/m/Y h:i') }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
