<?php

namespace App\Http\Controllers\Frontend\Payment;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderTransaction;
use App\Models\Product;
use App\Models\User;
use App\Models\UserAddress;
use App\Notifications\Backend\User\OrderCreatedNotification;
use App\Notifications\Frontend\User\OrderThanksNotification;
use App\Services\OmnipayService;
use App\Services\OrderService;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf;
use Meneses\LaravelMpdf\Facades\LaravelMpdf as PDF;
use Predis\Response\Status;

class PaypalController extends Controller
{

    public function statusQrCode(Request $request)
    {
        $client = new \GuzzleHttp\Client();

        $response = $client->request('GET', 'https://api.pagar.me/core/v5/charges/'.$request->id, [
          'headers' => [
            'accept' => 'application/json',
            'authorization' => 'Basic '.env('KEY_PAGARME'),
          ],
        ]);
        
        echo $response->getBody();
    }
    public function getQrCode(Request $request)
    {

       
        $client = new \GuzzleHttp\Client();
        $ddd =  Utils::getDDD(auth()->user()->phone);
        $phone = Utils::PhoneWithoutDDD(auth()->user()->phone);
        $defaultCollection = session('cart')['default'];


        // dd($request->amount);
        foreach ($defaultCollection as $rowId => $cartItem) {


            //dd($cartItem->price);

            $itens[] = [
                "amount" => $cartItem->price,
                "description" => $cartItem->name,
                "quantity" => $cartItem->qty,
                "code" => $cartItem->id
            ];
        }

        //data para pix
        $data = [
            "customer" => [
                "phones" => [
                   "home_phone" => [
                        "country_code" => "55",
                        "area_code" => $ddd,
                        "number" => $phone
                    ]
                ],
                "name" => auth()->user()->full_name,
                "email" => auth()->user()->email,
                "type" => "individual",
                "document" => Utils::sanitizeCpfCnpj(auth()->user()->document),
                "document_type" => "CPF",
                "code" => auth()->user()->id
            ],
            "items" =>
            $itens,
            "payments" => [
                [
                    "Pix" => [
                        "expires_in" => 52134613
                    ],
                    "payment_method" => "pix",
                    "amount" => str_replace(".","",$request->amount),
                ]
            ],
            "session_id" => "765765757",
            "ip" => "52.168.67.32",
            "closed" => false,
           
        ];

        $response = $client->request('POST', 'https://api.pagar.me/core/v5/orders', [
            'body' => json_encode($data),
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Basic '.env('KEY_PAGARME'),
                'content-type' => 'application/json',
            ],
        ]);

        echo $response->getBody();
    }

    public function teste(Request $request)
    {
        $client = new \GuzzleHttp\Client();
        $addressCustomer = Utils::getAddresComplet($request->addressId);
        $ddd =  Utils::getDDD(auth()->user()->phone);
        $phone = Utils::PhoneWithoutDDD(auth()->user()->phone);

        $defaultCollection = session('cart')['default'];



        foreach ($defaultCollection as $rowId => $cartItem) {


            $itens[] = [
                "amount" => $cartItem->price,
                "description" => $cartItem->name,
                "quantity" => $cartItem->qty,
                "code" => $cartItem->id
            ];
        }


        //data para credit
        $data = [
            "customer" => [
                "phones" => [
                    "home_phone" => [
                        "country_code" => "55",
                        "area_code" => $ddd,
                        "number" => $phone
                    ]
                ],
                "name" => auth()->user()->full_name,
                "email" => auth()->user()->email,
                "type" => "individual",
                "document" => Utils::sanitizeCpfCnpj(auth()->user()->document),
                "document_type" => "CPF"
            ],
            "items" =>
            $itens,
            "payments" => [
                [
                    "credit_card" => [
                        "card" => [
                            "billing_address" => [
                                "line_1" => $addressCustomer['logradouro'],
                                "zip_code" => $addressCustomer['cep'],
                                "city" => $addressCustomer['localidade'],
                                "country" => "BR",
                                "state" => $addressCustomer['uf']
                            ],
                            "number" => $request->cardNumber,
                            "holder_name" => $request->cardName,
                            "exp_month" => explode("/", $request->expirationDate)[0],
                            "exp_year" => explode("/", $request->expirationDate)[1],
                            "cvv" => $request->securityCode
                        ],
                        "installments" => 1,
                        "statement_descriptor" => "Ton Ton"
                    ],
                    "payment_method" => "credit_card",
                    "amount" => str_replace(".","",$request->card_amount),
                    // "amount" => 100,
                ]
            ]
        ];

        $response = $client->request('POST', 'https://api.pagar.me/core/v5/orders', [
            'body' => json_encode($data),
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Basic '.env('KEY_PAGARME'),
                'content-type' => 'application/json',
            ],
        ]);

        echo $response->getBody();
    }
    public function store(Request $request)
    {

       
        $order = (new OrderService())->createOrder($request->except(['_token', 'submit']));

        $omniPay = new OmnipayService('PayPal_Express');
        $response = $omniPay->purchase([
            'amount' => $order->total,
            'transactionId' => $order->id,
            'currency' => $order->currency,
            'cancelUrl' => $omniPay->getCancelUrl($order->id),
            'returnUrl' => $omniPay->getReturnUrl($order->id)
        ]);

        $this->completed($order->id);
        if ($response->isRedirect()) {
          
            $response->redirect();
        }

        toast($response->getMessage(), 'error');
        return redirect()->route('user.orders');
    }

    public function cancelled($orderId): RedirectResponse
    {
        $order = Order::find($orderId);

        $order->update([
            'order_status' => Order::CANCELED
        ]);
        $order->products()->each(function ($orderProduct) {
            $product = Product::whereId($orderProduct->pivot->product_id)->first();
            $product->update([
                'quantity' => $product->quantity + $orderProduct->pivot->quantity
            ]);
        });

        toast('You have canceled your order payment!', 'error');
        return redirect()->route('user.orders');
    }

    public function completed($orderId): RedirectResponse
    {
        $order = Order::with('products', 'user', 'paymentMethod')->find($orderId);

        $omniPay = new OmnipayService('PayPal_Express');
        $response = $omniPay->complete([
            'amount' => $order->total,
            'transactionId' => $order->id,
            'currency' => $order->currency,
            'cancelUrl' => $omniPay->getCancelUrl($order->id),
            'returnUrl' => $omniPay->getReturnUrl($order->id),
            'notifyUrl' => $omniPay->getNotifyUrl($order->id)
        ]);

       
            $order->update(['order_status' => Order::PAID]);
            $order->transactions()->create([
                'transaction_status' => OrderTransaction::PAID,
                'transaction_number' => $response->getTransactionReference(),
                'payment_result' => 'success'
            ]);
        

        if (session()->has('coupon')) {
            $coupon = Coupon::whereCode(session()->get('coupon')['code'])->first();
            $coupon->increment('used_times');
        }

        Cart::instance('default')->destroy();

        session()->forget([
            'coupon',
            'saved_user_address_id',
            'saved_shipping_company_id',
            'saved_payment_method_id',
            'shipping'
        ]);

        // Notification to admins.
        User::role(['admin', 'supervisor'])->each(function ($admin, $key) use ($order) {
            $admin->notify(new OrderCreatedNotification($order));
        });

        // Send email with PDF invoice
        $data = $order->toArray();
        $data['currency_symbol'] = "RS";
        $pdf = LaravelMpdf::loadView('layouts.invoice', $data);
        $saved_file = storage_path('app/pdf/files/' . $data['ref_id'] . '.pdf');
        $pdf->save($saved_file);

        $user = User::find($order->user_id);
        $user->notify(new OrderThanksNotification($order, $saved_file));

        toast('You have recent payment is successful with reference code: ' . $response->getTransactionReference(), 'success');
        return redirect()->route('home');
    }

    public function webhook($order, $env)
    {
        // feature..
    }
}
