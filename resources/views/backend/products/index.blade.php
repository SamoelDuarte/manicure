@extends('layouts.admin')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">
                Produtos
            </h6>
            <div class="ml-auto">
                @can('create_category')
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                        <span class="icon text-white-50">
                            <i class="fa fa-plus"></i>
                        </span>
                        <span class="text">Novo Produto</span>
                    </a>
                @endcan
            </div>
        </div>

        @include('partials.backend.filter', ['model' => route('admin.products.index')])

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>IMG</th>
                        <th>Nome</th>
                        <th>Quantidade</th>
                        <th>Valor</th>
                        {{-- <th>Tags</th> --}}
                        <th>Categoria</th>
                        <th>Status</th>
                        <th>Criado em</th>
                        <th class="text-center" style="width: 30px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td style="text-align: center; vertical-align: middle;">
                                @if ($product->hasProductML())
                                    <a href="#" data-toggle="modal" id="productMLModalLink"
                                        data-target="#productMLModal" data-product-id="{{ $product->id }}"
                                        style="display: inline-block; position: relative;">
                                        <img src="{{ asset('storage/images/icons/icone.png') }}" width="25"
                                            height="25" alt="Mercado Livre"
                                            style="box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.5); border-radius: 50%;">
                                    </a>
                                @else
                                    {{ $product->id }}
                                @endif
                            </td>
                            <td>
                                @if ($product->firstMedia)
                                    <img src="{{ asset('storage/images/products/' . $product->firstMedia->file_name) }}"
                                        width="60" height="60" alt="{{ $product->name }}">
                                @else
                                    <img src="{{ asset('img/no-img.png') }}" width="60" height="60"
                                        alt="{{ $product->name }}">
                                @endif
                            </td>
                            <td><a href="{{ route('admin.products.show', $product->id) }}">{{ $product->name }}</a></td>
                            <td>{{ $product->quantity }}</td>
                            <td>R$ {{ $product->formatted_price }}</td>
                            {{-- <td class="text-danger">{{ $product->tags->pluck('name')->join(', ') }}</td> --}}
                            <td>{{ $product->category ? $product->category->name : null }}</td>
                            <td>{{ $product->status }}</td>
                            <td>{{ $product->created_at_formatted }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-primary">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0);"
                                        onclick="if (confirm('Are you sure to delete this record?'))
                                       {document.getElementById('delete-product-{{ $product->id }}').submit();} else {return false;}"
                                        class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                    id="delete-product-{{ $product->id }}" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="10">Nenhum Produto Encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="10">
                            <div class="float-right">
                                {!! $products->appends(request()->all())->links() !!}
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="productMLModal" tabindex="-1" role="dialog" aria-labelledby="productMLModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productMLModalLabel">Produtos do Mercado Livre</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Aqui você pode adicionar a tabela com os detalhes do ProductML -->
                    <!-- Exemplo: -->
                    <!-- Dentro do modal -->
                    <table class="table" id="productMLTable">
                        <thead>
                            <tr>
                                <th>Nome da Conta</th>
                                <th>Permalink</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Aqui serão adicionadas as linhas dinamicamente -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>

    <script>
        $(document).ready(function() {
            // Quando o modal for exibido
            $('#productMLModal').on('shown.bs.modal', function() {
                // Obtemos o ID do produto do atributo data
                var productId = $('#productMLModalLink').data('product-id');
                // Faça uma requisição AJAX para a sua rota no controlador
                $.ajax({
                    url: '/admin/mercadolibre/getPermaLink/' + productId,
                    method: 'GET',
                    success: function(data) {
                        // Limpa a tabela
                        $('#productMLTable tbody').empty();

                        // Adiciona as linhas com os dados recebidos
                        $.each(data, function(index, item) {
                            var rowHtml =
                                '<tr>' +
                                '<td>' + item.conta_ml.nickname + '</td>' +
                                '<td>' +
                                '<div class="d-flex align-items-center">' +
                                '<span class="mr-2">' +
                                '<a href="' + item.permalink +
                                '" target="_blank" title="Abrir Link">' +
                                '<i class="fas fa-eye" style="cursor: pointer;"></i>' +
                                '</a>' +
                                '</span>' +
                                '<span class="permalink-text d-none">' + item
                                .permalink + '</span>' +
                                '<i class="far fa-copy ml-2 copy-icon" data-clipboard-text="Valdeir Psr" data-toggle="tooltip" data-placement="top" title="Copiar Link" style="cursor: pointer;"></i>' +
                                '<i class="fas fa-check ml-2 check-icon" style="display: none;"></i>' +
                                '</div>' +
                                '</td>' +
                                '</tr>';

                            $('#productMLTable tbody').append(rowHtml);
                        });

                        // Inicializa o ClipboardJS após adicionar os elementos dinâmicos
                        const clipboard = new ClipboardJS('.copy-icon', {
    text: function (trigger) {
        var permalinkText = $(trigger).siblings('.permalink-text').text();
        console.log('Permalink Text:', permalinkText); // Adicione esta linha para depuração
        return permalinkText;
    }
});

                        // Exibe a mensagem de "Copiado" e adiciona a animação
                        clipboard.on('success', function(e) {
                            window.getSelection().removeAllRanges();
                            var copyIcon = $(e.trigger);
                            var checkIcon = copyIcon.siblings('.check-icon');

                            copyIcon.hide();
                            checkIcon.show();

                            setTimeout(function() {
                                copyIcon.show();
                                checkIcon.hide();
                            }, 1500);
                        });
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>
@endsection
