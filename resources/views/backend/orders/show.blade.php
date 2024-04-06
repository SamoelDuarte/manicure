@extends('layouts.admin')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Pedido ({{ $order->ref_id }})</h6>
            <div class="ml-auto">
                <form action="{{ route('admin.orders.update', $order) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-row align-items-center">
                        <label class="sr-only" for="inlineFormInputGroupUsername">Status do Pedido</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Status do Pedido</div>
                            </div>
                            <select class="form-control" name="order_status" style="outline-style: none;" onchange="this.form.submit()">
                                <option value=""> Escolhaa Ação </option>
                                @foreach($orderStatusArray as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="d-flex">
            <div class="col-8">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>Ref. Id</th>
                            <td>{{ $order->ref_id }}</td>
                            <th>Cliente</th>
                            @if ($order->user_id)
                            <td><a href="{{ route('admin.users.show', $order->user_id) }}">{{ $order->user->full_name }}</a></td>
                            @else
                                <label for="">Mercado Livre</label>
                            @endif
                           
                        </tr>
                        <tr>
                            @if ($order->user_id)
                            <th>Endereço</th>
                            <td>
                                <a href="{{ route('admin.user_addresses.show', $order->user_address_id) }}">
                                    {{ $order->userAddress->title }}
                                </a>
                            </td>
                            <th>Entrega</th>
                            <td>{{ $order->name_shipping . '('. $order->number_shipping .')' }}</td>
                            @else
                                  <label for="">Mercado Livre</label>
                            @endif
                           
                        </tr>
                        <tr>
                            <th>Tipo Entrega :</th>
                            <td>{{ '('. $order->model_shipping .')' }}</td>
                        </tr>
                        <tr>
                            <th>Data</th>
                            <td>{{ $order->created_at->format('d/m/Y h:i') }}</td>
                            <th>Order status</th>
                            <td>{!! $order->statusWithBadge() !!}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-4">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>Subtotal</th>
                            <td>{{ $order->currency() . $order->subtotal }}</td>
                        </tr>
                        <tr>
                            <th>Codigo de Desconto</th>
                            <td>{{ $order->discount_code }}</td>
                        </tr>
                        <tr>
                            <th>Desconto</th>
                            <td>{{ $order->currency() . $order->discount }}</td>
                        </tr>
                        <tr>
                            <th>Taxa(Entrega)</th>
                            <td>{{ $order->currency() . $order->shipping }}</td>
                        </tr>
                        <tr>
                            <th>Taxa</th>
                            <td>{{ $order->currency() . $order->tax }}</td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <td>{{ $order->currency() . $order->total }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Transação</h6>
        </div>
    
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Transação</th>
                        <th>Número da transação</th>
                        <th>Resultado do pagamento</th>
                        <th>Data da ação</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($order->transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->transaction_status }}</td>
                        <td>{{ $transaction->transaction_number }}</td>
                        <td>{{ $transaction->payment_result }}</td>
                        <td>{{ $transaction->created_at->format('Y-m-d h:i a') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">Nenhuma transação encontrada</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detalhes</h6>
        </div>
    
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($order->products as $product)
                    <tr>
                        <td>
                            <a href="{{ route('admin.products.show', $product->id) }}">
                                {{ $product->name }}
                            </a>
                        </td>
                        <td>{{ $product->pivot->quantity }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2">Nenhum produto encontrado</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
@endsection
