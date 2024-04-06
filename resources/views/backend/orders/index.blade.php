@extends('layouts.admin')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">
                Orders
            </h6>
            <div class="ml-auto">

            </div>
        </div>

        @include('backend.orders.filter')

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Ref ID</th>
                        <th>Usuário</th>
                        <th>Método de Pagamento</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>
                                <a href="{{ route('admin.orders.show', $order) }}">
                                    {{ $order->ref_id }}
                                </a>
                            </td>
                            <td>{{ $order->user->full_name ?? $order->mercadoLivre->nickname }}</td>
                            <td>{{ $order->paymentMethod->name ?? 'Pagamento ML'}}</td>
                            <td>{{ $order->currency() . ' ' . $order->total }}</td>
                            <td>{!! $order->statusWithBadge() !!}</td>
                            <td>{{ $order->created_at->format('d/m/Y H:i ') }}</td>
                            <td>
                                @if ($order->number_label_shipping)
                                <a href="javascript:void(0);" onclick="printLabel('{{ $order->number_label_shipping }}')"
                                    class="btn btn-sm btn-info">
                                    <i class="fa fa-print"></i> Imprimir Etiqueta 
                                </a>
                                @else
                                <a href="{{ route('admin.mercadolivre.imprimirEtiqueta', ['order' => $order]) }}"
                                    class="btn btn-sm btn-info" target="_blank">
                                    <i class="fa fa-print"></i> Imprimir Etiqueta
                                </a>
                                    
                                @endif
                                
                                <a href="javascript:void(0);"
                                    onclick="if (confirm('Are you sure to delete this record?'))
                                   {document.getElementById('delete-order-{{ $order->id }}').submit();} else {return false;}"
                                    class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i>
                                </a>
                                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST"
                                    id="delete-order-{{ $order->id }}" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="6">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6">
                            <div class="float-right">
                                {!! $orders->appends(request()->all())->links() !!}
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- Modal para exibir a etiqueta -->
        <div class="modal" id="labelModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Etiqueta do Pedido</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <iframe id="labelFrame" width="100%" height="500px"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    function printLabel(numberLabel) {
        window.location.href = `/admin/etiqueta/${numberLabel}`;
    }
</script>
