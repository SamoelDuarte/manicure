<?php

namespace App\Http;

use App\Http\Controllers\Utils;
use App\Models\MercadoLivreData;
use App\Models\ProductImage;
use App\Models\ProductML;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class MercadoLivre
{

    protected $httpClient;
    protected $clientId;
    protected $clientSecret;
    protected $redirectUri;

    public function __construct()
    {
        $this->httpClient = new Client();
        $this->clientId = env('SERVICES_MERCADOLIVRE_CLIENT_ID');
        $this->clientSecret = env('SERVICES_MERCADOLIBRE_CLIENT_SECRET');
        $this->redirectUri = env('SERVICES_MERCADOLIBRE_REDIRECT_URI');
    }

    public function getAuthUrl()
    {
        // Construa a URL de autorização do Mercado Livre
        $url = "https://auth.mercadolivre.com.br/authorization?response_type=code&client_id={$this->clientId}&redirect_uri={$this->redirectUri}";



        return $url;
    }

    public static function conected()
    {
        $userID = session('userData')->id;
        $token = MercadoLivreData::where('user_id', $userID)->first();

        return isset($token);
    }

    public function handleCallback($code)
    {
        // Use o código obtido no callback para obter o token de acesso
        $data = $this->requestAccessToken($code);

        // Retorne o token de acesso
        return $data;
    }
    public function getUserDataML($token)
    {
        $client = new Client();
        $headers = [
            'Authorization' => 'Bearer ' . $token
        ];
        $request = new Psr7Request('GET', 'https://api.mercadolibre.com/users/me', $headers);
        $res = $client->sendAsync($request)->wait();
        return json_decode($res->getBody(), true);
    }

    public function updateIMG($product)
    {

        $media = $product->media;


        // Monta a lista de imagens para a carga útil
        $pictureArray = [];
        foreach ($media as $image) {
            // Obtém a URL da imagem
            $source = asset('storage/images/products/' . $image->file_name);

            // Adiciona a imagem à lista
            $pictureArray[] = ["source" => $source];
        }

        // dd($pictureArray);


        $ids_ml = ProductML::with('conta_ml')->where('product_id', $product->id)->get();

        foreach ($ids_ml as $id_ml) {
            // Defina a URL para criar um produto no Mercado Livre
            $url = 'https://api.mercadolibre.com/items/' . $id_ml->id_ml;

            //  dd(json_encode($productPayload));
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL =>  $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'PUT',
                CURLOPT_POSTFIELDS => json_encode(array("pictures" => $pictureArray)),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: text/plain',
                    'Authorization: Bearer ' . $id_ml->conta_ml->access_token
                ),
            ));

            $response = curl_exec($curl);

            $respArray = json_decode($response, true);

            if (isset($respArray['id'])) {

                flash('Img Atualizado no  Mercado Livre')->success();
            } else {
                flash('Error ao Inserir no Mercado Livre')->error();
            }
        }
        array('success' => 'Upload de imagens feito com sucesso no Mercado Livre');
    }

    protected function requestAccessToken($code)
    {
        // Faça uma solicitação POST para obter o token de acesso
        $response = $this->httpClient->post('https://api.mercadolibre.com/oauth/token', [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'code' => $code,
                'redirect_uri' => $this->redirectUri,
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);



        // Aqui, você pode processar os dados do token de acesso conforme necessário

        return $data;
    }
    public function getProduct($productId)
    {
        // Implementar a lógica para obter informações de um produto no Mercado Livre
    }
    public function createProductML($product)
    {
        $media = $product->media;

        // Defina a URL para criar um produto no Mercado Livre
        $url = 'https://api.mercadolibre.com/items';
        // Monta a lista de imagens para a carga útil
        $pictureArray = [];
        foreach ($media as $image) {
            // Obtém a URL da imagem
            $source = asset('storage/images/products/' . $image->file_name);

            // Adiciona a imagem à lista
            $pictureArray[] = ["source" => $source];
        }

        $productPayload = [
            'title' => $product['name'],
            'category_id' => $product['categorie_ml'],
            'price' => $this->marKupML(floatVal($product['price'])),
            'currency_id' => "BRL",
            'available_quantity' => $product['quantity'],
            'condition' => $product['condition'],
            'listing_type_id' => "gold_premium",
            'attributes' => [
                ['id' => 'MODEL', 'value_name' => $product['model'],],
                ['id' => 'BRAND', 'value_name' => $product['brand'],],
                ['id' => 'WRENCH_TYPE', 'value_name' => $product['brand'],],
            ], 'pictures' => $pictureArray
            // "pictures" => [
            //     ["source" => "http://localhost:8000/storage/catalog/products/AHcuiGEAuFE2K0wCLwDuw7dZQ22CzR0GOliZh9hP.gif"],

            // ]
        ];
        // dd($productPayload);




        $contasMl = MercadoLivreData::where('user_id',  auth()->user()->id)->get();

        foreach ($contasMl as $conta) {
            //  dd(json_encode($productPayload));
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL =>  $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($productPayload),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: text/plain',
                    'Authorization: Bearer ' . $conta->access_token
                ),
            ));

            $response = curl_exec($curl);

            $respArray = json_decode($response, true);
            if (isset($respArray['id'])) {
                //  dd($conta->id);

                $newproductMl = new ProductML();
                $newproductMl->create([
                    'id_ml' => $respArray['id'],
                    'id_conta_ml' => $conta->id,
                    'product_id' => $product->id,
                    'permalink' => $respArray['permalink'],

                ]);

                $productData['id_ml'] = $respArray['id'];
                $productData['description'] = $product->description;

                $this->descriptionProductML($productData, $conta->access_token);
                flash('Inserido no ML na Conta' . $conta->email)->success();
            } else {
                flash('Error ao Inserir no Mercado Livre')->error();
                // dd($respArray);
            }
        }
    }

    public function updateProductML($data)
    {




        $productsML = ProductML::with('conta_ml')->where('product_id', $data->id)->get();

        foreach ($productsML as $productML) {
            $conta = $productML->conta_ml;
            // dd($productML->id_ml);
            // Defina a URL para criar um produto no Mercado Livre
            $url = 'https://api.mercadolibre.com/items/' . $productML->id_ml;

            $productPayload = [
                'title' => $data->name,
                'price' => $this->marKupML($data->price),
                'available_quantity' => $data->quantity
            ];

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL =>  $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'PUT',
                CURLOPT_POSTFIELDS => json_encode($productPayload),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: text/plain',
                    'Authorization: Bearer ' . $conta->access_token
                ),
            ));

            $response = curl_exec($curl);

            $respArray = json_decode($response, true);
            // dd($respArray);
            if (isset($respArray['id'])) {
                $data['id_ml'] = $respArray['id'];
                $this->descriptionProductML($data, $conta->access_token);


                flash('atualizado no ML na Conta' . $conta->email)->success();
                if (isset($data->upImage)) {
                    $this->updateIMG($data);
                }
            } else {
                flash('Error ao Atualizar no Mercado Livre')->error();
            }
        }
        //  dd(json_encode($productPayload));

    }
    public function descriptionProductML($data, $access_token)
    {
        // Defina a URL para criar um produto no Mercado Livre
        $url = 'https://api.mercadolibre.com/items/' . $data['id_ml'] . '/description';

        $productPayload = [
            'plain_text' => Utils::removeTags($data['description'])
        ];
        //  dd(json_encode($productPayload));
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL =>  $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => json_encode($productPayload),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: text/plain',
                'Authorization: Bearer ' . $access_token
            ),
        ));

        $response = curl_exec($curl);

        $respArray = json_decode($response, true);
    }
    public function marKupML($price)
    {

        // Calcula 13% do preço
        $percent = 0.13;
        $percentageAmount = ($price * $percent) + $price;

        // Adiciona 6,00 reais
        $totalPrice = $percentageAmount + 6.00;

        // Verifica se o preço é maior que 100 reais
        if ($totalPrice > 100.00) {
            // Se for maior que 100 reais, adiciona 27,00 reais
            $totalPrice += 27.00;
        }

        return number_format($totalPrice, 2, '.', '');
    }

    public function updateProduct($productId, $productData)
    {
        // Implementar a lógica para atualizar um produto no Mercado Livre
    }

    public function getOrder($orderId)
    {
        // Implementar a lógica para obter informações de um pedido no Mercado Livre
    }

    public function createOrder($orderData)
    {
        // Implementar a lógica para criar um novo pedido no Mercado Livre
    }

    // Outras funcionalidades do Mercado Livre...

    // Métodos auxiliares, como autenticação e manipulação de respostas, podem ser adicionados aqui.
}
