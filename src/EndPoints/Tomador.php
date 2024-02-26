<?php

namespace SavioVarsalle\LaravelGissOnline\EndPoints;

use GuzzleHttp\Exception\RequestException;
use SavioVarsalle\LaravelGissOnline\GissOnline;

class Tomador
{
    private GissOnline $service;
    private $codMunicipio;
    private $idEmpresa;
    private $token;
    private $cnpjCpf;
    private $bairro;
    private $cep;
    private $cidade;
    private $complemento;
    private $estado;
    private $idIbge;
    private $idUfIbge;
    private $logradouro;
    private $numero;
    private $tipoLogradouro;
    private $apelido;
    private $notaTipo;
    private $email;
    private $exterior;
    private $nomeFantasia;
    private $razaoSocial;
    private $codigoArea;
    private $telefone;
    private $mei;
    private $inscricaoEstadual;
    private $inscricaoMunicipal;
    private $simplesNacional;
    private $idTomador;
    private $ativo;

    public function __construct(array $data)
    {
        $this->service      = new GissOnline;
        $this->codMunicipio = env('GISS_COD_MUNICIPIO_PRESTADOR');
        $this->idEmpresa    = data_get($data, 'idEmpresa', '') ;
        $this->token        = data_get($data, 'token', '');
        $this->cnpjCpf = data_get($data, 'cnpjCpf', null);
        $this->bairro = data_get($data, 'bairro');
        $this->cep = data_get($data, 'cep');
        $this->cidade = data_get($data, 'cidade');
        $this->complemento = data_get($data, 'complemento');
        $this->estado = data_get($data, 'estado');
        $this->idIbge = data_get($data, 'idIbge');
        $this->idUfIbge = data_get($data, 'idUfIbge');
        $this->logradouro = data_get($data, 'logradouro');
        $this->numero = data_get($data, 'numero');
        $this->tipoLogradouro = data_get($data, 'tipoLogradouro');
        $this->apelido = data_get($data, 'apelido');
        $this->notaTipo = data_get($data, 'notaTipo');
        $this->email = data_get($data, 'email');
        $this->exterior = data_get($data, 'exterior');
        $this->nomeFantasia = data_get($data, 'nomeFantasia');
        $this->razaoSocial  = data_get($data, 'razaoSocial');
        $this->codigoArea   = data_get($data, 'codigoArea');
        $this->telefone = data_get($data, 'telefone');
        $this->mei = data_get($data, 'mei');
        $this->inscricaoEstadual    = data_get($data, 'inscricaoEstadual');
        $this->inscricaoMunicipal   = data_get($data, 'inscricaoMunicipal');
        $this->simplesNacional = data_get($data, 'simplesNacional');
        $this->idTomador = data_get($data, 'idTomador');
        $this->ativo = data_get($data, 'ativo', true);
    }

    public function get()
    {
        try {
            $response = $this->service->api->request('GET', "https://gissv2-{$this->codMunicipio}.giss.com.br/service-empresa/api/cliente-fornecedor/tomador/{$this->codMunicipio}/{$this->idEmpresa}/tipo/1/cliente/2024-02-23?parametro={$this->cnpjCpf}", [
                'headers' => [
                    'Accept'        => 'application/json, text/plain, */*',
                    'Accept-Encoding' => 'gzip, deflate, br, zstd',
                    'Authorization' => 'Bearer ' . $this->token
                ],
            ]);

            if ($response->getStatusCode() != 200) {
                return json_decode($response->getBody()->getContents());
            }

            $dadosBasicos = json_decode($response->getBody()->getContents());
            
            $response = $this->service->api->request('GET', "https://gissv2-{$this->codMunicipio}.giss.com.br/service-empresa/api/empresa/endereco/{$this->codMunicipio}/{$dadosBasicos->conteudo[0]->id}", [
                'headers' => [
                    'Accept'        => 'application/json, text/plain, */*',
                    'Accept-Encoding' => 'gzip, deflate, br, zstd',
                    'Authorization' => 'Bearer ' . $this->token
                ],
            ]);
            
            if ($response->getStatusCode() >= 200) {
                return json_decode($response->getBody()->getContents());
            } else {
                return "Erro na requisição";
            }
        } catch (RequestException $e) {
            return "Erro na requisição: " . $e->getMessage();
        }
    }

    public function create()
    {
        try {
            $response = $this->service->api->request('POST', "https://gissv2-{$this->codMunicipio}.giss.com.br/service-empresa/api/cliente-fornecedor/", [
                'headers' => [
                    'Accept'        => 'application/json, text/plain, */*',
                    'Accept-Encoding' => 'gzip, deflate, br, zstd',
                    'Authorization' => 'Bearer ' . $this->token,
                    'Content-Type' => 'application/json;charset=UTF-8'
                ],
                'json' => [
                    'alterado'  => true,
                    'apelido'   => $this->apelido,
                    'documento' => $this->cnpjCpf,
                    'email'   => [
                        'alterado' => true,
                        'email' => $this->email
                    ],
                    'endereco' => [
                        'alterado' => true,
                        'bairro' => $this->bairro,
                        'cep' => $this->cep,
                        'cidade' => $this->cidade,
                        'complemento' => $this->complemento,
                        'estado' => $this->estado,
                        'idIbge' => $this->idIbge,
                        'idUfIbge' => $this->idUfIbge,
                        'logradouro' => $this->logradouro,
                        'numero' => $this->numero,
                        'tipoLogradouro' => $this->tipoLogradouro
                    ],
                    'exterior' => $this->exterior,
                    'idCliente' => $this->codMunicipio,
                    'idEmpresa' => $this->idEmpresa,
                    'nomeFantasia' => $this->nomeFantasia,
                    'razaoSocial' => $this->razaoSocial,
                    'simplesNacional' => $this->simplesNacional,
                    'inscricaoEstadual' =>  $this->inscricaoEstadual,
                    'inscricaoMunicipal' => $this->inscricaoMunicipal,
                    'telefone' => [
                        'alterado' => true,
                        'codigoArea' => $this->codigoArea,
                        'telefone' => $this->telefone
                    ],
                    'mei' => $this->mei,
                    'tipo' => 1,
                    'tipoEmpresa' => '1',
                    'ativo' => $this->ativo
                ]
            ]);

            if ($response->getStatusCode() >= 200) {
                return json_decode($response->getBody()->getContents());
            } else {
                return "Erro na requisição";
            }
        } catch (RequestException $e) {
            return "Erro na requisição: " . $e->getMessage();
        }
    }
    public function update()
    {
        try {
            $response = $this->service->api->request('PUT', "https://gissv2-{$this->codMunicipio}.giss.com.br/service-empresa/api/cliente-fornecedor/", [
                'headers' => [
                    'Accept'        => 'application/json, text/plain, */*',
                    'Accept-Encoding' => 'gzip, deflate, br, zstd',
                    'Authorization' => 'Bearer ' . $this->token,
                    'Content-Type' => 'application/json;charset=UTF-8'
                ],
                'json' => [
                    'alterado'  => true,
                    'id' => $this->idTomador,
                    'ativo' => $this->ativo,
                    'apelido'   => $this->apelido,
                    'documento' => $this->cnpjCpf,
                    'email'   => [
                        'alterado' => true,
                        'email' => $this->email
                    ],
                    'endereco' => [
                        'alterado' => true,
                        'bairro' => $this->bairro,
                        'cep' => $this->cep,
                        'cidade' => $this->cidade,
                        'complemento' => $this->complemento,
                        'estado' => $this->estado,
                        'idIbge' => $this->idIbge,
                        'idUfIbge' => $this->idUfIbge,
                        'logradouro' => $this->logradouro,
                        'numero' => $this->numero,
                        'tipoLogradouro' => $this->tipoLogradouro
                    ],
                    'exterior' => $this->exterior,
                    'idCliente' => $this->codMunicipio,
                    'idEmpresa' => $this->idEmpresa,
                    'nomeFantasia' => $this->nomeFantasia,
                    'razaoSocial' => $this->razaoSocial,
                    'simplesNacional' => $this->simplesNacional,
                    'inscricaoEstadual' =>  $this->inscricaoEstadual,
                    'inscricaoMunicipal' => $this->inscricaoMunicipal,
                    'telefone' => [
                        'alterado' => true,
                        'codigoArea' => $this->codigoArea,
                        'telefone' => $this->telefone
                    ],
                    'mei' => $this->mei,
                    'tipo' => 1,
                    'tipoEmpresa' => '1'
                ]
            ]);

            if ($response->getStatusCode() >= 200) {
                return json_decode($response->getBody()->getContents());
            } else {
                return "Erro na requisição";
            }
        } catch (RequestException $e) {
            return "Erro na requisição: " . $e->getMessage();
        }
    }
}
