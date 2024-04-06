@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Autorização do Bling</h1>

        @if($isAuthenticated)
            {{-- Mostrar informações da conta do Bling --}}
            <p>Você está autenticado no Bling.</p>
            <p>Nome da Empresa: {{ $blingAccountInfo['company_name'] }}</p>
            {{-- Adicione mais informações conforme necessário --}}
        @else
            {{-- Mostrar botão de autorização --}}
            <a href="/admin/bling/auth" class="btn btn-primary">Autorizar Bling</a>
        @endif
    </div>
@endsection
