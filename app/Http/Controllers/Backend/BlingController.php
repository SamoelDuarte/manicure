<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BlingData;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BlingController extends Controller
{
    public function index()
    {
        // Verificar se o usuário está autenticado no Bling (lógica fictícia)
        $isAuthenticated = $this->checkBlingAuthentication();

        // Se autenticado, obter informações da conta (lógica fictícia)
        $blingAccountInfo = [];
        if ($isAuthenticated) {
            $blingAccountInfo = $this->getBlingAccountInfo();
        }

        return view('backend.bling.index', compact('isAuthenticated', 'blingAccountInfo'));
    }

    public function handleAuth()
    {

        // Dados do cliente (substitua com os seus)
        $clientId = env('BLING_CLIENT_ID');
        $clientSecret = env('BLING_CLIENT_SECRET');

        // URL de autorização do Bling
        $authorizationUrl = 'https://www.bling.com.br/Api/v3/oauth/authorize';

        // Gere uma sequência de caracteres aleatórios para o estado
        $state = bin2hex(random_bytes(16));

        // Redirecionar para a URL de autorização com os parâmetros necessários
        return redirect()->away($authorizationUrl . '?' . http_build_query([
            'response_type' => 'code',
            'client_id' => $clientId,
            'state' => $state,
        ]));
    }
    public function subToken(Request $request){
          // Dados do cliente (substitua com os seus)
          $clientId = env('BLING_CLIENT_ID');
          $clientSecret = env('BLING_CLIENT_SECRET');
  
          // URL de token do Bling
          $tokenUrl = 'https://www.bling.com.br/Api/v3/oauth/token';
  
          // Configurações para a requisição com Guzzle
          $client = new Client();
  
          // Faz a requisição POST para obter o token de acesso
          $response = $client->post($tokenUrl, [
              'headers' => [
                  'Authorization' => 'Basic ' . base64_encode($clientId . ':' . $clientSecret),
              ],
              'form_params' => [
                  'grant_type' => 'authorization_code',
                  'code' => $request->code,
              ],
          ]);
  
        
          // Decodifica a resposta JSON
          $tokenData = json_decode($response->getBody(), true);
  
          BlingData::create([
            'access_token' => $tokenData['access_token'],
            'expires_in' => $tokenData['expires_in'],
            'token_type' => $tokenData['token_type'],
            'scope' => $tokenData['scope'],
            'refresh_token' => $tokenData['refresh_token'],
        ]);

        return response('Token de acesso obtido e salvo no banco de dados com sucesso.');
    }


    // Adicione métodos de verificação e obtenção de informações conforme necessário

    private function checkBlingAuthentication()
    {
       // Verifica se há um token de acesso válido no banco de dados
    $accessToken = BlingData::where('expires_in', '>', now())->value('access_token');

    return !empty($accessToken);
    }

    private function getBlingAccountInfo()
    {
        // Lógica para obter informações da conta no Bling
        // Retorne um array com as informações da conta
        return [
            'company_name' => 'Nome da Empresa Exemplo',
            // Adicione mais informações conforme necessário
        ];
    }

    public function refreshToken()
    {
        $clientId = env('BLING_CLIENT_ID');
        $clientSecret = env('BLING_CLIENT_SECRET');
       

        // URL de token do Bling
        $tokenUrl = 'https://www.bling.com.br/Api/v3/oauth/token';

        // Obtém o último registro de token no banco de dados
        $lastToken = BlingData::latest('created_at')->first();

        // Verifica se há um token disponível para refresh
        if (!$lastToken || empty($lastToken->refresh_token)) {
            return response('Não há um token de refresh disponível.', 400);
        }

        // Configurações para a requisição com Guzzle
        $client = new Client();

        // Faz a requisição POST para obter um novo token de acesso usando o refresh token
        $response = $client->post($tokenUrl, [
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode($clientId . ':' . $clientSecret),
            ],
            'form_params' => [
                'grant_type' => 'refresh_token',
                'refresh_token' => $lastToken->refresh_token,
            ],
        ]);

        // Decodifica a resposta JSON
        $tokenData = json_decode($response->getBody(), true);

        // Salva os novos tokens no banco de dados
        BlingData::create([
            'access_token' => $tokenData['access_token'],
            'expires_in' => $tokenData['expires_in'],
            'token_type' => $tokenData['token_type'],
            'scope' => $tokenData['scope'],
            'refresh_token' => $tokenData['refresh_token'],
        ]);

        return response('Token de acesso atualizado com sucesso.');
    }

    public function criarNota(Request $request)
    {
        // Dados do cliente obtidos do .env
        $clientId = env('BLING_CLIENT_ID');
        $clientSecret = env('BLING_CLIENT_SECRET');

        // Dados da nota a ser criada
        $dadosNota = [
            "tipo" => 1,
            "numero" => "6541",
            "dataOperacao" => "2023-01-12 09:52:12",
            "contato" => [
                "nome" => "Contato do Bling",
                "tipoPessoa" => "J",
                "numeroDocumento" => "30188025000121",
                "ie" => "7364873393",
                "rg" => "451838701",
                "contribuinte" => 1,
                "telefone" => "54 3771-7278",
                "email" => "pedrosilva@bling.com.br",
                "endereco" => [
                    "endereco" => "Olavo Bilac",
                    "numero" => "914",
                    "complemento" => "Sala 101",
                    "bairro" => "Imigrante",
                    "cep" => "95702-000",
                    "municipio" => "Bento Gonçalves",
                    "uf" => "RS",
                    "pais" => ""
                ]
            ],
            "naturezaOperacao" => [
                "id" => 12345678
            ],
            "loja" => [
                "id" => 12345678,
                "numero" => "LOJA_8864"
            ],
            "finalidade" => 1,
            "seguro" => 1.15,
            "despesas" => 5.08,
            "desconto" => 10.12,
            "observacoes" => "Observação da nota.",
            "documentoReferenciado" => [
                "modelo" => "55",
                "data" => "2023-01-12",
                "numero" => "123",
                "serie" => "1",
                "contadorOrdemOperacao" => "1",
                "chaveAcesso" => "62634519764512837946527549134679858182373412"
            ],
            "itens" => [
                [
                    "codigo" => "BLG-5",
                    "descricao" => "Produto do Bling",
                    "unidade" => "UN",
                    "quantidade" => 1,
                    "valor" => 4.9,
                    "tipo" => "P",
                    "pesoBruto" => 0.5,
                    "pesoLiquido" => 0.5,
                    "numeroPedidoCompra" => "235",
                    "classificacaoFiscal" => "9999.99.99",
                    "cest" => "99.999.99",
                    "codigoServico" => "99.99",
                    "origem" => 0,
                    "informacoesAdicionais" => "Descrição do item"
                ]
            ],
            "parcelas" => [
                [
                    "data" => "2023-01-12",
                    "valor" => 123.45,
                    "observacoes" => "Observação da parcela",
                    "formaPagamento" => [
                        "id" => 12345678
                    ]
                ]
            ],
            "transporte" => [
                "fretePorConta" => 0,
                "frete" => 20,
                "veiculo" => [
                    "placa" => "LDO-2373",
                    "uf" => "RS",
                    "marca" => "Volvo"
                ],
                "transportador" => [
                    "nome" => "Transportador",
                    "numeroDocumento" => "30188025000121",
                    "ie" => "949895756023",
                    "endereco" => [
                        "endereco" => "Olavo Bilac",
                        "municipio" => "Bento Gonçalves",
                        "uf" => "RS"
                    ]
                ],
                "volume" => [
                    "quantidade" => 5,
                    "especie" => "Volumes",
                    "numero" => "1",
                    "pesoBruto" => 0.5,
                    "pesoLiquido" => 0.35
                ],
                "volumes" => [
                    [
                        "servico" => "ALIAS_123",
                        "codigoRastreamento" => "COD123BR"
                    ]
                ],
                "etiqueta" => [
                    "nome" => "Transportador",
                    "endereco" => "Olavo Bilac",
                    "numero" => "914",
                    "complemento" => "Sala 101",
                    "municipio" => "Bento Gonçalves",
                    "uf" => "RS",
                    "cep" => "95702-000",
                    "bairro" => "Imigrante"
                ]
            ],
            "notaFiscalProdutorRuralReferenciada" => [
                "numero" => "125",
                "serie" => "1",
                "data" => "2023-01-12"
            ],
            "intermediador" => [
                "cnpj" => "13921649000197",
                "nomeUsuario" => "usuario"
            ]
        ];
        
        // Configurações para a requisição com Guzzle
        $client = new Client();

        // Obtém o token de acesso válido
        $token = BlingData::first();
       

        // Adiciona o token de acesso aos headers da requisição
        $headers = [
            'Authorization' => 'Bearer ' . $token->access_token,
            'Content-Type' => 'application/json',
        ];

        // Faz a requisição POST para o endpoint de criação de nota/nfe
        $response = $client->post('https://www.bling.com.br/Api/v3/nfe', [
            'headers' => $headers,
            'json' => $dadosNota,
        ]);

        // Decodifica a resposta JSON
        $responseData = json_decode($response->getBody(), true);

        // Manipula a resposta conforme necessário
        // ...

        return response('Nota criada com sucesso.');
    }

    
}
