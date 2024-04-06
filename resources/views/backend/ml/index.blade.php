@extends('layouts.admin')

@section('title', '- Categorias')

@section('content')

    <!-- Page Heading -->
    <div class="page-header-content py-3">

        <div class="d-sm-flex align-items-center justify-content-between">
            <h1 class="h3 mb-0 text-gray-800">Contas ML</h1>
            <a href="/admin/mercadolibre/auth" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus text-white-50"></i> Autenticar Nova Conta Mercado Livre
            </a>
        </div>

        <ol class="breadcrumb mb-0 mt-4">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Contas ML</li>
        </ol>

    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col-lg-12 mb-4">

            @include('flash::message')

            <!-- Project Card Example -->
            <div class="card shadow mb-4">



                <div class="card-body">

                    <div class="table-categorias">

                        <table class="table table-bordered">

                            <thead>
                                <tr>

                                    <th scope="col">Nickname</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Perfil ML</th>
                                    <th scope="col" style="width: 20%">Ações</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach ($contasML as $contaML)
                                    <tr>
                                        <td>{{ $contaML->nickname }}</td>
                                        <td>{{ $contaML->email }}</td>
                                        <td><a href="{{ $contaML->permalink }}" target="_blank">
                                                <button class="btn btn-link">
                                                    <i class="fa fa-eye"></i> Visualizar
                                                </button>
                                            </a></td>

                                        <td width="15%">
                                           
                                            <a href="javascript:;" id="openModalButton" data-ml-id="{{ $contaML->id }}"
                                                class="btn btn-sm btn-success openModalButton">Dados ML</a>
                                                <a href="#" class="btn btn-sm btn-danger btn-excluir" data-toggle="modal" data-target="#modalDelete" data-id="{{ $contaML->id }}">Excluir</a>

                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>

                        </table>



                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Modal para exibição de dados do Mercado Livre -->
    <div class="modal fade" id="modalMLData" tabindex="-1" role="dialog" aria-labelledby="modalMLDataLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalMLDataLabel">Dados do Mercado Livre</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Nickname:</strong> <span id="mlDataNickname"></span></p>
                    <p><strong>Email:</strong> <span id="mlDataEmail"></span></p>
                    <p><strong>Nome:</strong> <span id="mlDataFirstName"></span></p>
                    <p><strong>Sobrenome:</strong> <span id="mlDataLastName"></span></p>
                    <p><strong>Endereço:</strong> <span id="mlDataAddress"></span></p>
                    <p><strong>Cidade:</strong> <span id="mlDataCity"></span></p>
                    <p><strong>Estado:</strong> <span id="mlDataState"></span></p>
                    <p><strong>CEP:</strong> <span id="mlDataZipCode"></span></p>
                    <p><strong>Telefone:</strong> <span id="mlDataPhone"></span></p>
                    <p><strong>Token:</strong> <span id="mlDataToken"></span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h5 class="py-3 m-0">Tem certeza que deseja excluir este registro?</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Fechar</button>
                    <form id="deleteForm" action="/admin/mercadolibre/deleteContaML" method="POST" class="float-right">
                        @csrf
                        <input type="hidden" id="id" name="id">
                        <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('.openModalButton').click(function() {
            var mlId = $(this).data('ml-id');
            // Faça uma solicitação AJAX para obter os dados do Mercado Livre
            $.ajax({
                type: 'GET',
                url: '/admin/mercadolibre/getMLData',
                data: {
                    mlId: mlId
                }, // Passar o ID como parâmetro
                success: function(response) {
                    $('#mlDataNickname').text(response.nickname);
                    $('#mlDataEmail').text(response.email);
                    $('#mlDataFirstName').text(response.first_name);
                    $('#mlDataLastName').text(response.last_name);
                    $('#mlDataAddress').text(response.address);
                    $('#mlDataCity').text(response.city);
                    $('#mlDataState').text(response.state);
                    $('#mlDataZipCode').text(response.zip_code);
                    $('#mlDataPhone').text(response.phone);
                    $('#mlDataToken').text(response.access_token);

                    // Abrir o modal
                    $('#modalMLData').modal('show');
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function () {
        // Set the id in the modal when the delete button is clicked
        $('.btn-excluir').on('click', function () {
            var id = $(this).data('id');
            $('#id').val(id);
            console.log(id);
        });

        // Submit the form when the modal delete button is clicked
        $('#modalDelete').on('click', '.btn-danger', function () {
            $('#deleteForm').submit();
        });
    });
</script>
