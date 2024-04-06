<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderTransaction;
use App\Models\Product;
use App\Models\Shipping;
use Gloudemans\Shoppingcart\Facades\Cart;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Str;

class OrderService
{
    public function createOrder($request)
    {
        $order = Order::create([
            'ref_id' => 'ORD-' . Str::random(15),
            'user_id' => auth()->id(),
            'user_address_id' => $request['userAddressId'],
            'payment_method_id' => $request['paymentMethodId'],
            'subtotal' => getNumbersOfCart()->get('subtotal'),
            'discount_code' => session()->has('coupon') ? session()->get('coupon')['code'] : NULL,
            'discount' => getNumbersOfCart()->get('discount'),
            'shipping' => getNumbersOfCart()->get('shipping'),
            'tax' => getNumbersOfCart()->get('productTaxes'),
            'total' => getNumbersOfCart()->get('total'),
            'currency' => 'BRL',
            'order_status' => 1,
            'name_shipping' => session()->get('shipping')['nameShipping'],
            'number_shipping' =>  session()->get('shipping')['idShipping'],
            'model_shipping' =>  session()->get('shipping')['modelShipping'],
        ]);

        $content = Cart::content();
        foreach ($content as $item) {

            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $item->model->id,
                'quantity' => $item->qty
            ]);
            $product = Product::find($item->model->id);
            $product->update(['quantity' => $product->quantity - $item->qty]);
        }

        $order->transactions()->create([
            'transaction_status' => OrderTransaction::NEW_ORDER,
            'transaction_number' => $request['idTransaction']
        ]);


        $this->requestTransport($request, $content,$order);

         return $order;
    }

    public function requestTransport($data, $productsCard,$order)
    {
      

        $client = new Client();
        $headers = [
            'token' => env('TOKEN_KANGU'),
            'Content-Type' => 'application/json',
        ];
        $address = auth()->user()->addresses->where('id', $data['userAddressId'])->first();

        $productSend = array();
        foreach ($productsCard as $item) {
            $productSend[] = array(
                "peso" =>  0.280,
                "altura" =>  10,
                "largura" =>  11,
                "comprimento" =>  20,
                "tipo" =>  "C",
                "produto" =>  $item->name,
                "valor" =>  $item->price,
                "quantidade" =>  $item->qty
            );
        }

        $body = [
            "gerarPdf" => false,
            "formatoPdf" => "true",
            "pedido" => [
                "tipo" => "D",
                "numero" => "",
                "serie" => "",
                "chave" => "",
                "chaveCTe" => "",
                "xml" => "",
                "numeroCli" => $order->id,
                "vlrMerc" => getNumbersOfCart()->get('total'),
                "pesoMerc" => 1
            ],
            "remetente" => [
                "nome" => "Beta Solução LTDA",
                "cnpjCpf" => "48312121000103",
                "endereco" => [
                    "logradouro" => "rua Bonifacio Pasquali",
                    "numero" => "34",
                    "complemento" => "string",
                    "bairro" => "JD jujihara",
                    "cep" => "04929400",
                    "cidade" => "São Paulo",
                    "uf" => "SP"
                ],
                "contato" => "Samoel ",
                "email" => "sac@duartevariedade.com.br",
                "telefone" => "string",
                "celular" => "11986123660"
            ],
            "destinatario" => [
                "nome" => auth()->user()->first_name . " " . auth()->user()->last_name,
                "cnpjCpf" => auth()->user()->document,
                "endereco" => [
                    "logradouro" => $address->address,
                    "numero" => $address->number,
                    "complemento" => $address->complement,
                    "bairro" => $address->neighborhood,
                    "cep" => $address->zipcode,
                    "cidade" => $address->city,
                    "uf" => $address->state,
                ],
                "contato" => auth()->user()->first_name . " " . auth()->user()->last_name,
                "email" => auth()->user()->email,
                "telefone" => "string",
                "celular" => auth()->user()->phone
            ],
            "produtos" => 
                $productSend
            ,
            "pontoPostagem" => "06951744000178",
            "pontoEntrega" => "06951744000178",
            "transportadora" => "string",
            "referencia" => session()->get('shipping')['referenceShipping'],
            "servicos" => [
                session()->get('shipping')['modelShipping'],
            ]
        ];


        // Convertendo o array para uma string JSON
        $bodyJson = json_encode($body);
        $request = new Request('POST', 'https://portal.kangu.com.br/tms/transporte/solicitar', $headers, $bodyJson);
        $res = $client->sendAsync($request)->wait();
        $responseArray = json_decode($res->getBody(), true);

        $order->code_shipping =  $responseArray['codigo'];
        $order->number_label_shipping = $responseArray['etiquetas'][0]['numero'];
        $order->update();
        
    }
}
