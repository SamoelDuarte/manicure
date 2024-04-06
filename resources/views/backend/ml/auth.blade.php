<!-- resources/views/auth/mercado-livre.blade.php -->

@extends('admin.layout.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Autenticação do Mercado Livre</div>
                    <div class="card-body">
                        <p>Clique no botão abaixo para autenticar com o Mercado Livre:</p>
                        <a href="/admin/mercadolibre/auth" class="btn btn-primary">Autenticar no Mercado Livre</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
