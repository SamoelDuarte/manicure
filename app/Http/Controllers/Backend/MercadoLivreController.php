<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\MercadoLivre;
use App\Models\MercadoLivreData;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderTransaction;
use App\Models\Product;
use App\Models\ProductML;
use App\Models\User;
use App\Notifications\Backend\User\OrderCreatedNotification;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Gloudemans\Shoppingcart\Facades\Cart;
use GuzzleHttp\Psr7\Request as RequestGuzzle;


class MercadoLivreController extends Controller
{
    public function index()
    {
        $contasML = MercadoLivreData::get();
        return view('backend.ml.index', compact('contasML'));
    }
    public function handleAuth()
    {
        $auth = new MercadoLivre();
        $authUrl = $auth->getAuthUrl();

        return redirect($authUrl);
    }
    public function getPermaLink($id){

        // Busca os registros em ProductML onde product_id é igual ao ID recebido
    $productMLData = ProductML::with('conta_ml')->where('product_id', $id)->get();

    return response()->json($productMLData);
    
     

    }
    public function imprimirEtiqueta($order)
    {

        $order = Order::with('mercadoLivre')->where('id',$order)->first();
       

      
        $client = new Client();
        try {

             // Obtenha o $ACCESS_TOKEN real da sua aplicação no Mercado Livre
        $ACCESS_TOKEN = $order->mercadoLivre->access_token;

        // Obtenha o ID de envio do pedido
        $idEnvio = $order->id_shipping_ml;

        // Crie uma instância do cliente Guzzle
        $client = new Client();

        // Faça a requisição à API do Mercado Livre para obter a etiqueta em PDF
        $response = $client->request('GET', "https://api.mercadolibre.com/shipment_labels?shipment_ids={$idEnvio}&savePdf=Y", [
            'headers' => [
                'Authorization' => "Bearer {$ACCESS_TOKEN}",
            ],
        ]);

        // Verifique se a solicitação foi bem-sucedida (código 200)
        if ($response->getStatusCode() === 200) {
            // Obtenha o conteúdo do PDF
            $pdfContent = $response->getBody()->getContents();

            // Salve ou manipule o PDF conforme necessário
            // Exemplo: Salvar em um arquivo
            $pdfPath = storage_path("etiqueta_{$order->number_label_shipping}.pdf");
            file_put_contents($pdfPath, $pdfContent);

            // Abra uma nova aba no navegador com o PDF
            return response()->file($pdfPath);
        } else {
            // Lógica para lidar com erros, se necessário
            return response()->json(['error' => 'Erro na solicitação da etiqueta'], 500);
        }

           
        } catch (\Exception $e) {
            // Trate qualquer exceção que possa ocorrer durante a solicitação
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
       
       
    }
    public function pedido(Request $request)
    {


        // Obtenha o conteúdo do pedido em JSON
        $pedidoConteudo = json_decode($request->getContent(), true);



        // Caminho do arquivo onde você deseja salvar o conteúdo do pedido
        $caminhoArquivo = storage_path('pedidos/' . now()->format('Ymd_His') . '_pedido.json');

        // Salve o conteúdo do pedido no arquivo
        File::put($caminhoArquivo, $request->getContent());

        // dd('aki');
        if ($pedidoConteudo['topic'] == "orders_v2") {


            $contaML = MercadoLivreData::where('id_ml', $pedidoConteudo['user_id'])->first();
            $accessToken = $contaML->access_token; // Substitua pelo seu token de acesso

            $client = new Client();

            try {
                $response = $client->get('https://api.mercadolibre.com' . $pedidoConteudo['resource'], [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $accessToken,
                        'Content-Type' => 'application/json',
                    ],
                ]);

                // Obtenha o corpo da resposta
                $conteudoResposta = json_decode($response->getBody()->getContents(), 1);
                $pedidoExistente = Order::where('id_ml', $conteudoResposta['id'])->first();


                // dd($conteudoResposta);
                if ($pedidoExistente) {
                    $this->updatePedido($conteudoResposta);
                }else{
                    $conteudoResposta['id_conta_ml'] = $contaML->id;
                    $this->salvaPedido($conteudoResposta);
                }
               
            } catch (\Exception $e) {
                // Trate qualquer exceção que possa ocorrer durante a solicitação
                return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
            }
        }
    }
    public function salvaPedido($conteudoResposta)
    {

        $orderItems = $conteudoResposta['order_items'][0];
        $order = Order::create([
            'ref_id' => 'ORD-' . Str::random(15),
            'id_ml' => $conteudoResposta['id'],
            'subtotal' => $orderItems['unit_price'] * $orderItems['quantity'], // Ajuste conforme a lógica do seu sistema
            'discount_code' => $conteudoResposta['coupon']['id'],
            'discount' => $orderItems['discounts'] ?? 0, // Ajuste conforme a lógica do seu sistema
            'shipping' => $conteudoResposta['shipping_cost'] ?? 0, // Ajuste conforme a lógica do seu sistema
            'tax' => $conteudoResposta['taxes']['amount'] ?? 0,
            'total' => $conteudoResposta['total_amount'] ?? 0,
            'currency' => 'BRL',
            'id_shipping_ml' => $conteudoResposta['shipping']['id'],
            'order_status' => 1, // Ajuste conforme a lógica do seu sistema
            'id_conta_ml' => $conteudoResposta['id_conta_ml'] // Ajuste conforme a lógica do seu sistema
        ]);

      
      

        foreach ($conteudoResposta['order_items'] as $item) {
            $productML = ProductML::where('id_ml', $item['item']['id'])->first();
            // dd($productML->product);
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $productML->product->id,
                'quantity' => $item['quantity']
            ]);
            // Atualize a quantidade do produto conforme necessário

            $productML->product->update(['quantity' => $productML->product->quantity - $item['quantity']]);
        }

        $order->transactions()->create([
            'transaction_status' => OrderTransaction::NEW_ORDER,
            'transaction_number' => $conteudoResposta['id']
        ]);

          //  // Notification to admins.
        //  User::role(['admin', 'supervisor'])->each(function ($admin, $key) use ($order) {
        //     $admin->notify(new OrderCreatedNotification($order));
        // });


        return $order;
    }

    public function updatePedido($conteudoResposta)
    {


        // dd($conteudoResposta['status']);
        $pedidoExistente = Order::where('id_ml', $conteudoResposta['id'])->first();
        if ($conteudoResposta['status'] == "cancelled") {
          

            // Atualize as informações principais do pedido
            $pedidoExistente->update([
                'updated_at' => $conteudoResposta['last_updated'],
                'order_status' => 5,
                // Adicione outros campos para atualização conforme necessário
            ]);


            // Atualize os itens do pedido
            foreach ($conteudoResposta['order_items'] as $item) {
                $productML = ProductML::where('id_ml', $item['item']['id'])->first();

                $productML->product->update(['quantity' => $productML->product->quantity + $item['quantity']]);
            }
        }


        // Atualize as informações de pagamento, se necessário
        foreach ($conteudoResposta['payments'] as $pagamento) {

            $pagamentoExistente = OrderTransaction::where('order_id', $pedidoExistente->id)
                ->where('transaction_number', $pagamento['order_id'])
                ->first();

            $pagamentoExistente->update(['transaction_status' => 5]);
        }
    }

    public function verifyToken()
    {
    }

    public function getMLData(Request $request)
    {

        $dadosMercadoLivre = MercadoLivreData::where('id', $request->mlId)->first();

        // dd($dadosMercadoLivre);

        return response()->json($dadosMercadoLivre);
    }
    public function handleMercadoLibreCallback(Request $request)
    {

        $code = $request->query('code');
        $userID = auth()->user()->id;
        $auth = new MercadoLivre();
        $data = $auth->handleCallback($code);
        $userML = $auth->getUserDataML($data['access_token']);

        $verify = MercadoLivreData::firstOrNew(['id_ml' => $userML['id']]);



        if ($verify->exists) {

            flash('Conta já Vinculada')->error();
        } else {
            $mercadoLivreData = new MercadoLivreData();
            $mercadoLivreData->user_id = $userID;
            $mercadoLivreData->nickname = $userML['nickname'];
            $mercadoLivreData->id_ml = $userML['id'];
            $mercadoLivreData->first_name = $userML['first_name'];
            $mercadoLivreData->last_name = $userML['last_name'];
            $mercadoLivreData->email = $userML['email'];
            $mercadoLivreData->address = $userML['address']['address'];
            $mercadoLivreData->city = $userML['address']['city'];
            $mercadoLivreData->state = $userML['address']['state'];
            $mercadoLivreData->zip_code = $userML['address']['zip_code'];
            $mercadoLivreData->refresh_token = $data['refresh_token'];
            $mercadoLivreData->phone = $userML['alternative_phone']['area_code'] . $userML['alternative_phone']['number'];
            $mercadoLivreData->permalink = $userML['permalink'];
            $mercadoLivreData->access_token = $data['access_token'];
            $mercadoLivreData->save();
        }

        return redirect('/admin/mercadolibre/');
    }
    public function getCategories()
    {
        $userID = session('userData')->id;
        $token = MercadoLivreData::where('user_id', $userID)->first();
        $client = new Client();
        $headers = [
            'Authorization' => 'Bearer ' . $token->token
        ];
        $body = '';
        $request = new Psr7Request('GET', 'https://api.mercadolibre.com/sites/MLB/categories', $headers, $body);
        $res = $client->sendAsync($request)->wait();
        echo $res->getBody();
    }

    public function deleteContaML(Request $request)
    {


        // dd($request->all());
        ProductML::where('id_conta_ml', $request->id)->delete();
        $mercadoLivreData = MercadoLivreData::where('id', $request->id)->first();

        if ($mercadoLivreData) {
            // Se o registro existe, você pode excluí-lo
            $mercadoLivreData->delete();
            flash('Deletado Com Sucesso.')->success();
        }

        return redirect('/admin/mercadolibre/');
        // Agora o registro foi excluído do banco de dados
    }
    public function getLinksML(Request $request)
    {

        $products = ProductML::select('permalink')->where('product_id', $request->mlId)->get();
        $data = array('links' => $products);
        return response()->json($data);
    }

    public function refreshToken(){

        $contasMl = MercadoLivreData::get();
        // Dados do cliente (substitua com os seus)
        $clientId = env('SERVICES_MERCADOLIVRE_CLIENT_ID');
        $clientSecret = env('SERVICES_MERCADOLIBRE_CLIENT_SECRET');

        foreach($contasMl as $contaMl){

            
            $client = new Client();
            $headers = [
              'Content-Type' => 'application/x-www-form-urlencoded'
            ];
            $options = [
            'form_params' => [
              'grant_type' => 'refresh_token',
              'client_id' => $clientId ,
              'client_secret' => $clientSecret,
              'refresh_token' => $contaMl->refresh_token
            ]];
            $request = new RequestGuzzle('POST', 'https://api.mercadolibre.com/oauth/token', $headers);
            $res = $client->sendAsync($request, $options)->wait();
            $resp = json_decode($res->getBody(),1) ;

            $contaMl->update(['refresh_token' => $resp['refresh_token'],'access_token' => $resp['access_token']]);
            //  dd($resp);
        }
    }
}
