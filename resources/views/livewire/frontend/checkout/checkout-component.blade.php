<div>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .green-text {
            color: green;
        }
    </style>

    <div class="row">
        <div class="col-lg-6 col-md-12 col-12">
            <h2 class="h5 text-uppercase mb-4">ENDEREÇOS DE ENVIO</h2>
            <div class="row">
                @forelse($addresses as $address)
                    <div class="col-6 form-group">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="address-{{ $address->id }}" class="custom-control-input"
                                wire:model="userAddressId" wire:click="getShippingCompanies()"
                                {{ intval($userAddressId) == $address->id ? 'checked' : '' }}
                                value="{{ $address->id }}">

                            <label for="address-{{ $address->id }}" class="custom-control-label text-small">
                                <b>{{ $address->title }}</b>
                                <small>
                                    {{ $address->address }} ,N° {{ $address->number }}<br>
                                    {{ $address->neighborhood }} - {{ $address->city }}- {{ $address->state }}

                                </small>
                            </label>
                        </div>
                    </div>
                @empty
                    <div class="col-6 form-group">
                        <p class="text-danger">Nenhum endereço encontrado</p>
                        <a class="btn btn-dark" href="{{ route('user.addresses') }}">Add Novo Endereço</a>
                    </div>
                @endforelse
            </div>
            @if ($userAddressId)
                <input type="hidden" id="address-id" value="{{ $userAddressId }}">
                <h2 class="h5 text-uppercase mb-4">Forma de Envio</h2>
                <div class="row">

                    @forelse($shippingCompanies as  $shippingCompany)
                        @if (!isset($shippingCompany['pontosRetira']))
                            <div class="col-6 form-group">

                                <div class="custom-control custom-radio">
                                    <input type="radio" id="shipping-company-{{ $shippingCompany['idTransp'].$shippingCompany['servico'] }}"
                                        class="custom-control-input" wire:model="shippingCompanyId"
                                        wire:click="storeShippingCost()"
                                        {{ intval($shippingCompanyId) == $shippingCompany['idTransp'] ? 'checked' : '' }}
                                        value="{{ $shippingCompany['idTransp'] }}">
                                    <label for="shipping-company-{{ $shippingCompany['idTransp'].$shippingCompany['servico'] }}"
                                        class="custom-control-label text-small">
                                        <b>{{ $shippingCompany['transp_nome']  }}</b><br>
                                        <small>
                                            Entre {{ $shippingCompany['prazoEnt'] }} Dias
                                            <br>
                                            {{ $shippingCompany['descricao'] }} (R$ <span
                                                class="green-text">{{ $shippingCompany['vlrFrete'] }} </span>)
                                        </small>

                                    </label>
                                </div>

                            </div>
                        @endif
                    @empty
                    @endforelse

                    @forelse($shippingCompanies as  $shippingCompany)
                        @if (isset($shippingCompany['pontosRetira']))
                            <div class="col-md-12">
                                <h2 class="h5 text-uppercase">Retirar em Uma Agencia</h2>
                                <small class="valor-produto">
                                    Entre {{ $shippingCompany['prazoEnt'] }} Dias
                                    {{ $shippingCompany['descricao'] }} (R$ <span
                                        class="green-text">{{ $shippingCompany['vlrFrete'] }}</span>)
                                </small>
                            </div>

                            @foreach ($shippingCompany['pontosRetira'] as $pontosRetira)
                                {{-- {{ dd($pontosRetira) }} --}}


                                <div class="col-6 form-group">

                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="shipping-company-{{ $pontosRetira['id'] }}"
                                            class="custom-control-input" wire:model="shippingCompanyId"
                                            wire:click="storeShippingCost()"
                                            {{ intval($pontosRetira) == $pontosRetira['id'] ? 'checked' : '' }}
                                            value="{{ $pontosRetira['id'] }}">
                                        <label for="shipping-company-{{ $pontosRetira['id'] }}"
                                            class="custom-control-label text-small">

                                           <b> {{ $pontosRetira['nome'] }}</b> <br> <small>{{ $pontosRetira['endereco']['bairro'] }}</small>

                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    @empty
                        <p>Nenhuma Forma de Envio</p>
                    @endforelse
                </div>
                
            @endif
            @if ($userAddressId && $shippingCompanyId)
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal3">
                    Cartão de Crédito
                </button>
                <!-- Botões para abrir os modais -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal1">
                    Pix
                </button>
                {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal2">
                    Boleto
                </button> --}}
            @endif



       


        </div>
        <form action="{{ route('payment.store') }}" method="POST" id="form-credit-card">
            @csrf


        </form>

        <div class="col-lg-6 col-md-12 col-12">
            
            <div class="your-order">
                <h4 class="mx-5">Seu Pedido</h4>
                <div class="your-order-table table-responsive">
                    <table>
                        <tbody>
                            <tr>
                                <th class="product-name">
                                    <strong>Subtotal</strong>
                                </th>
                                <th class="product-total">R$ {{ $cartSubTotal }}</th>
                            </tr>
                            @if (session()->has('coupon'))
                                <tr>
                                    <th class="product-name">
                                        <strong>Discount</strong>
                                        <small>({{ getNumbersOfCart()->get('discountCode') }})</small><br>
                                        <a wire:click.prevent="removeCoupon()"
                                            class="btn btn-link btn-sm text-decoration-none text-danger">
                                            <small>Remove coupon</small>
                                        </a>
                                    </th>
                                    <th class="product-total">- ${{ $cartDiscount }}</th>
                                </tr>
                            @endif
                            @if (session()->has('shipping'))
                                <tr>
                                    <th class="product-name">
                                        <strong>Shipping</strong>
                                        <small>({{ getNumbersOfCart()->get('shippingCode') }})</small>
                                    </th>
                                    <th class="product-total">R$ {{ $cartShipping }}</th>
                                </tr>
                            @endif
                            <tr>
                                <th class="product-name">
                                    <strong>Tax</strong>
                                </th>
                                <th class="product-total">R$ {{ $cartTax }}</th>
                            </tr>
                            <tr class="order-total">
                                <th>
                                    <strong>Total</strong>
                                </th>
                                <td>

                                    <strong><span>R$ {{ $cartTotal }}</span></strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                   
                </div>
               
            </div>
            <div wire:loading wire:target="storeShippingCost">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Carregando...</span>
                </div>
                Carregando detalhes...
            </div>
            <div>
                @if ($shippingCompanyDetails)
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Detalhes do Ponto de Retirada</h5>
                            <ul>
                                {{-- {{ dd($shippingCompanyDetails) }} --}}
                                <li><strong>Nome:</strong> {{ $shippingCompanyDetails['nome'] }}</li>
                                <li><strong>Endereço:</strong> {{ $shippingCompanyDetails['endereco']['logradouro'] }}, {{ $shippingCompanyDetails['endereco']['numero'] }} - {{ $shippingCompanyDetails['endereco']['bairro'] }}, {{ $shippingCompanyDetails['endereco']['cidade'] }}, {{ $shippingCompanyDetails['endereco']['uf'] }}, {{ $shippingCompanyDetails['endereco']['cep'] }}</li>
                                <li><strong>Contato:</strong> {{ $shippingCompanyDetails['contato'] }}</li>
                                <li><strong>Email:</strong> {{ $shippingCompanyDetails['email'] }}</li>
                                <li><strong>Telefone:</strong> {{ $shippingCompanyDetails['telefone'] }}</li>
                                <li><strong>Celular:</strong> {{ $shippingCompanyDetails['celular'] }}</li>
                                <li><strong>CPF/CNPJ:</strong>{{ $shippingCompanyDetails['cnpjCpf'] }}</li>
                                <!-- Adicione mais detalhes conforme necessário -->
                            </ul>
                            
                            <h5 class="card-title">Horários de Funcionamento</h5>
                            <ul>
                                @foreach ($shippingCompanyDetails['horarios'] as $horario)
                                    <li><strong>{{ $horario['dia'] }}:</strong> {{ $horario['abre'] }} - {{ $horario['fecha'] }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>


      
    </div>

         <!-- Modais -->
         <div class="modal fade" id="modal1" tabindex="-1" aria-labelledby="modal1Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal1Label">Pix</h5>
                        <small>escaneie o QrCode e Aguarde</small>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal"
                            aria-label="Fechar">X</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div id="qrcodeContainer" style="display: none;">
                                    <!-- Aqui você pode colocar o elemento que exibirá o QR Code carregado via AJAX -->
                                </div>
                                <div id="preloaderContainer" style="display: block;">
                                    <div class="preloader"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <img src="/img/scanner-qr-code.gif" style="width:221px">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal2" tabindex="-1" aria-labelledby="modal2Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal2Label">Modal 2</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        Conteúdo do Modal 2
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modal3" tabindex="-1" aria-labelledby="creditCardModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="creditCardModalLabel">Cartão de Crédito</h5>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal"
                            aria-label="Fechar">X</button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulário de Cartão de Crédito -->
                        <form id="creditCardForm">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="mb-3">
                                        <label for="cardName" class="form-label">Nome do Titular:</label>
                                        <input type="text" class="form-control title-case" id="cardName"
                                            name="cardName" required>
                                    </div>
                                </div>

                            </div>
                            <input type="hidden" name="card_amount" id="card_amount"
                                value="{{ $cartTotal }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="cardNumber" class="form-label">Número do Cartão:</label>
                                        <input type="text" class="form-control" id="cardNumber"
                                            name="cardNumber" required>
                                        <img id="cardTypeImage" style="width: 34px;display:none">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="securityCode" class="form-label">CVC</label>
                                        <input type="text" class="form-control" id="securityCode"
                                            name="securityCode" maxlength="3" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="expirationDate" class="form-label">Validade:</label>
                                        <input type="text" class="form-control" id="expirationDate"
                                            name="expirationDate" maxlength="5" required>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Pagar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"
        integrity="sha512-efAcjYoYT0sXxQRtxGY37CKYmqsFVOIwMApaEbrxJr4RwqVVGw8o+Lfh/+59TU07+suZn1BWq4fDl5fdgyCNkw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        // Simulação do carregamento do QR Code via AJAX
        // Supondo que você tenha carregado o QR Code em uma variável
        var qrCodeImage;
        var codtransacao;

        
        $('#modal1').on('show.bs.modal', function() {
            // Mostrar o preloader e esconder o QR Code carregado
            document.getElementById('preloaderContainer').style.display = 'block';
            document.getElementById('qrcodeContainer').style.display = 'none';
            const settings = {
                url: '/payment/payment_getQrCode',
                method: 'GET',
                data: {
                    amount: $('#card_amount').val()
                },
            };

            $.ajax(settings).done(function(response) {
                var responseArray = JSON.parse(response);
                codtransacao = responseArray['charges'][0]['id'];
          
                qrCodeImage = '<img src="' + responseArray['charges'][0]['last_transaction'][
                    'qr_code_url'
                ] + '" alt="QR Code" style="width:215px">';
            });

            // Simular um carregamento via AJAX
            setTimeout(function() {
                // Esconder o preloader e mostrar o QR Code carregado
                document.getElementById('preloaderContainer').style.display = 'none';
                document.getElementById('qrcodeContainer').style.display = 'block';
                document.getElementById('qrcodeContainer').innerHTML = qrCodeImage;

                setTimeout(function() {
                    fazerVerificacao();
                }, 6000);
            }, 3000); // Simulando um carregamento de 3 segundos via AJAX
        });



        function fazerVerificacao() {
            verificarIntervalo = setInterval(() => {
                // Simulação de uma chamada AJAX
                // Aqui você deve substituir o URL e a lógica de verificação real
                // Esta é apenas uma simulação
                const settings2 = {
                    url: '/payment/statusQrCode',
                    method: 'GET',
                    data: {
                        id: codtransacao
                    },
                };

                $.ajax(settings2).done(function(response) {
                    var responseArray = JSON.parse(response);

                    if (responseArray['status'] == "paid") {
                        Swal.fire({
                            icon: 'success',
                            text: 'Aguarde...',
                            title: 'Pago',
                            html: 'Pagamento Realizado Com sucesso.',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                   
                        pararVerificacao()
                        completOrder(2,responseArray['last_transaction']['id']);
                    } else {
                        // console.log(responseArray['last_transaction']['id']);
                        e.preventDefault();
                     

                        // completOrder(2,responseArray['last_transaction']['id']);
                    }
                });


            }, 3000); // 3000 milissegundos = 3 segundos'
        }


        function pararVerificacao() {
            clearInterval(verificarIntervalo);
        }


        $(document).ready(function() {
            // Máscara para número do cartão
            const cardNumberInput = $('#cardNumber');
            const securityCodeInput = $('#securityCode');

            const expirationDateInput = $('#expirationDate');

            cardNumberInput.inputmask('9999 9999 9999 9999', {
                placeholder: '____ ____ ____ ____'
            });

            securityCodeInput.inputmask('999', {
                placeholder: '___'
            });

            expirationDateInput.inputmask('99/99', {
                placeholder: '__/__'
            });

            // Limitar a 19 caracteres (incluindo espaços da máscara)
            cardNumberInput.attr('maxlength', '19');


            // Aceitar somente números
            cardNumberInput.on('input', function() {
                $(this).val($(this).val().replace(/\D/g, ''));
            });
            // Aceitar somente números
            securityCodeInput.on('input', function() {
                $(this).val($(this).val().replace(/\D/g, ''));
            });


            // Reconhecer a bandeira do cartão e atualizar a imagem
            cardNumberInput.on('input', function() {
                const cardNumber = cardNumberInput.inputmask('unmaskedvalue').replace(/\s/g, '');
                const cardType = getCardType(cardNumber);
                console.log(cardType);
                cardTypeImage.src = cardType !== 'unknown' ? `img/${cardType}.png` : '';
                cardTypeImage.style = "display:block;width:34px"

            });

            // Obtém o tipo de cartão com base nos primeiros dígitos do número do cartão
            function getCardType(cardNumber) {
                const cardTypes = {
                    visa: /^4/,
                    mastercard: /^5[1-5]/,
                    amex: /^3[47]/
                };

                for (const type in cardTypes) {
                    if (cardTypes[type].test(cardNumber)) {
                        return type;
                    }
                }
                return 'unknown';
            }

            // Resto do código de validação e submissão do formulário

            // Evento de envio do formulário usando AJAX
            $('#creditCardForm').submit(function(event) {
                event.preventDefault();

                const formData = new FormData(this); // Serializar o formulário em um objeto FormData

                // Adicionar o token do Laravel ao FormData
                const laravelToken = $('meta[name="csrf-token"]').attr('content');
                formData.append('_token', laravelToken);
                formData.append('addressId', $('#address-id').val())

                Swal.fire({
                    title: 'Aguarde...',
                    text: 'Processando o pagamento',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();

                        // Enviar o FormData via AJAX
                        $.ajax({
                            url: '/payment_teste', // Substitua pelo URL do seu script de backend
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                const jsonArray = JSON.parse(response);

                                console.log(jsonArray['charges'][0][
                                    'last_transaction'
                                ]['acquirer_message']);
                                if (jsonArray['charges'][0]['last_transaction']['acquirer_message'] === 'Transação aprovada com sucesso') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Autorizado com sucesso',
                                        text: 'O pagamento foi aprovado!',
                                    });
                                    // Dados para enviar na requisição

                                    completOrder(1);

                                } else  if (jsonArray['charges'][0]['last_transaction']['acquirer_message'] === 'Saldo insuficiente')  {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Erro',
                                        text: 'Não Autorizado',
                                    });
                                }else{
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Erro',
                                        text: 'Por favor Verifique os Dados.',
                                    });
                                }
                            },
                            error: function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erro',
                                    text: 'Verifique se Dados estão corretos.',
                                });
                            }
                        });
                    }
                });
            });


        });

        function completOrder(method,idtransaction) {
            let formCredit = $("#form-credit-card");

            let addressID = $('<input>')
                .attr('type', 'hidden')
                .attr('name', 'userAddressId')
                .val($('#address-id').val());

            formCredit.append(addressID);

            let shippingCompanyId = $('<input>')
                .attr('type', 'hidden')
                .attr('name', 'shippingCompanyId')
                .val(1);



            formCredit.append(shippingCompanyId);
            

            let paymentMethodId = $('<input>')
                .attr('type', 'hidden')
                .attr('name', 'paymentMethodId')
                .val(method);

            formCredit.append(paymentMethodId);

            let idTransactionInput = $('<input>')
                .attr('type', 'hidden')
                .attr('name', 'idTransaction')
                .val(idtransaction);
                
            formCredit.append(idTransactionInput);

            formCredit.submit();
        }
    </script>
@endsection
