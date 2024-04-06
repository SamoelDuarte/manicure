<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderTransaction;
use App\Models\User;
use App\Notifications\Frontend\User\OrderStatusNotification;
use App\Services\OmnipayService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function index(): View
    {
        $this->authorize('access_order');

        $orders = Order::with('user', 'paymentMethod')
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->whereOrderStatus(\request()->status);
            })
            ->orderBy(\request()->sortBy ?? 'id', \request()->orderBy ?? 'desc')
            ->paginate(\request()->limitBy ?? 10);

        return view('backend.orders.index', compact('orders'));
    }

    public function imprimir($numeroEtiqueta)
    {
        $url = "https://portal.kangu.com.br/tms/transporte/imprimir-etiqueta/{$numeroEtiqueta}";

        $response = Http::withHeaders([
            'token' => env('TOKEN_KANGU'),
            'Content-Type' => 'application/json',
        ])->get($url);
        $data = json_decode($response->body(), true);
        // Se o índice "pdf" estiver presente na resposta
        if (isset($data['pdf'])) {
            // Acesse o conteúdo do PDF em base64
            $pdfContent = $data['pdf'];

            // Decodifique o conteúdo do PDF para a representação binária
            $pdfBinary = base64_decode($pdfContent);

            // Envie o PDF como resposta
            return response($pdfBinary)->header('Content-Type', 'application/pdf');
        } else {
            // Lida com a situação em que o índice "pdf" não está presente na resposta
            // ...
        }
    }


    public function show(Order $order): View
    {
        $this->authorize('show_order');

        $orderStatusArray = [
            '0' => 'Novo pedido',
            '1' => 'Pago',
            '2' => 'Em processamento',
            '3' => 'Concluído',
            '4' => 'Rejeitado',
            '5' => 'Cancelado',
            '6' => 'Solicitação de reembolso',
            '7' => 'Pedido devolvido',
            '8' => 'Reembolsado',
        ];


        $key = array_search($order->order_status, array_keys($orderStatusArray));
        foreach ($orderStatusArray as $k => $v) {
            if ($k <= $key) {
                unset($orderStatusArray[$k]);
            }
        }

        return view('backend.orders.show', compact('order', 'orderStatusArray'));
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $this->authorize('edit_order');

        $user = User::find($order->user_id);

        if ($request->order_status == Order::REFUNDED) {
            $omniPay = new OmnipayService('PayPal_Express');
            $response = $omniPay->refund([
                'amount' => $order->total,
                'transactionReference' => $order->transactions()->where('transaction_status', OrderTransaction::PAID)
                    ->first()->transaction_number,
                'cancelUrl' => $omniPay->getCancelUrl($order->id),
                'returnUrl' => $omniPay->getReturnUrl($order->id),
                'notifyUrl' => $omniPay->getNotifyUrl($order->id),
            ]);

            if ($response->isSuccessful()) {
                $order->update(['order_status' => Order::REFUNDED]);
                $order->transactions()->create([
                    'transaction_status' => OrderTransaction::REFUNDED,
                    'transaction_number' => $response->getTransactionReference(), // coming from PayPal
                    'payment_result' => 'success'
                ]);

                $user->notify(new OrderStatusNotification($order));

                return back()->with([
                    'message' => 'Refunded successfully',
                    'alert-type' => 'success',
                ]);
            }
        } else {

            $order->update(['order_status' => $request->order_status]);

            $order->transactions()->create([
                'transaction_status' => $request->order_status,
                'transaction_number' => null,
                'payment_result' => null,
            ]);

            $user->notify(new OrderStatusNotification($order));

            return back()->with([
                'message' => 'updated successfully',
                'alert-type' => 'success',
            ]);
        }
    }

    public function destroy(Order $order): RedirectResponse
    {
        $this->authorize('delete_order');

        $order->delete();

        return redirect()->route('admin.orders.index')->with([
            'message' => 'Deleted successfully',
            'alert-type' => 'success'
        ]);
    }
}
