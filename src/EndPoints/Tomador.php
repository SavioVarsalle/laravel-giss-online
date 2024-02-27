<?php

namespace SavioVarsalle\LaravelGissOnline\EndPoints;

use SavioVarsalle\LaravelGissOnline\GissOnline;

class Tomador
{
    private GissOnline $service;

    private string $codMunicipio;

    private string $idEmpresa;

    private string $token;

    private string $cnpjCpf;

    private string $bairro;

    private string $cep;

    private string $cidade;

    private string $complemento;

    private string $estado;

    private int $idIbge;

    private int $idUfIbge;

    private string $logradouro;

    private string $numero;

    private string $tipoLogradouro;

    private string $apelido;

    private string $notaTipo;

    private string $email;

    private bool $exterior;

    private string $nomeFantasia;

    private string $razaoSocial;

    private int $codigoArea;

    private string $telefone;

    private bool $mei;

    private string $inscricaoEstadual;

    private string $inscricaoMunicipal;

    private bool $simplesNacional;

    private $idTomador;

    private bool $ativo;

    public function __construct(array $data)
    {
        $this->service            = new GissOnline();
        $this->codMunicipio       = data_get($data, 'GISS_COD_MUNICIPIO_PRESTADOR', env('GISS_COD_MUNICIPIO_PRESTADOR'));
        $this->idEmpresa          = data_get($data, 'idEmpresa', '');
        $this->token              = data_get($data, 'token', '');
        $this->cnpjCpf            = data_get($data, 'cnpjCpf', '');
        $this->bairro             = data_get($data, 'bairro', '');
        $this->cep                = data_get($data, 'cep', '', '');
        $this->cidade             = data_get($data, 'cidade', '');
        $this->complemento        = data_get($data, 'complemento', '');
        $this->estado             = data_get($data, 'estado', '');
        $this->idIbge             = data_get($data, 'idIbge', 0);
        $this->idUfIbge           = data_get($data, 'idUfIbge', 0);
        $this->logradouro         = data_get($data, 'logradouro', '');
        $this->numero             = data_get($data, 'numero', '');
        $this->tipoLogradouro     = data_get($data, 'tipoLogradouro', '');
        $this->apelido            = data_get($data, 'apelido', '');
        $this->notaTipo           = data_get($data, 'notaTipo', '');
        $this->email              = data_get($data, 'email', '', '');
        $this->exterior           = data_get($data, 'exterior', false);
        $this->nomeFantasia       = data_get($data, 'nomeFantasia', '');
        $this->razaoSocial        = data_get($data, 'razaoSocial', '');
        $this->codigoArea         = data_get($data, 'codigoArea', 0);
        $this->telefone           = data_get($data, 'telefone', '');
        $this->mei                = data_get($data, 'mei', false);
        $this->inscricaoEstadual  = data_get($data, 'inscricaoEstadual', '');
        $this->inscricaoMunicipal = data_get($data, 'inscricaoMunicipal', '');
        $this->simplesNacional    = data_get($data, 'simplesNacional', '');
        $this->idTomador          = data_get($data, 'idTomador', '');
        $this->ativo              = data_get($data, 'ativo', true);
    }

    public function get()
    {
        $response = $this->service->api->request('GET', "https://gissv2-{$this->codMunicipio}.giss.com.br/service-empresa/api/cliente-fornecedor/tomador/{$this->codMunicipio}/{$this->idEmpresa}/tipo/1/cliente/2024-02-23?parametro={$this->cnpjCpf}", [
            'headers' => [
                'Accept'          => 'application/json, text/plain, */*',
                'Accept-Encoding' => 'gzip, deflate, br, zstd',
                'Authorization'   => 'Bearer ' . $this->token,
            ],
        ]);

        return json_decode($response->getBody()->getContents());
    }

    public function create()
    {
        $endereco = $this->cep !== '' ? [
            "cep"            => $this->cep,
            "alterado"       => true,
            "logradouro"     => $this->logradouro,
            "bairro"         => $this->bairro,
            "idIbge"         => $this->idIbge,
            "idUfIbge"       => $this->idUfIbge,
            "estado"         => $this->estado,
            "tipoLogradouro" => $this->tipoLogradouro,
            "cidade"         => $this->cidade,
            "numero"         => $this->numero,
            "complemento"    => $this->complemento,
        ] : null;

        if ($endereco !== null) {
            $endereco = array_filter($endereco, function ($value) {
                return $value !== '' && $value !== "" && $value !== null && $value !== 0;
            });
        }

        $telefone = $this->telefone !== '' && $this->codigoArea !== 0 ? [
            "codigoArea" => $this->codigoArea,
            "alterado"   => true,
            "telefone"   => $this->telefone,
        ] : null;

        $email = $this->email !== '' ? [
            "email"    => $this->email,
            "alterado" => true,
        ] : null;

        $json = [
            "exterior"           => $this->exterior,
            "endereco"           => $endereco,
            "tipo"               => 1,
            "alterado"           => true,
            "razaoSocial"        => $this->razaoSocial,
            "documento"          => $this->cnpjCpf,
            "inscricaoMunicipal" => $this->inscricaoMunicipal,
            "inscricaoEstadual"  => $this->inscricaoEstadual,
            "nomeFantasia"       => $this->nomeFantasia,
            "apelido"            => $this->apelido,
            "telefone"           => $telefone,
            "email"              => $email,
            "idEmpresa"          => $this->idEmpresa,
            "idCliente"          => $this->codMunicipio,
            "tipoEmpresa"        => "1",
        ];

        $json = array_filter($json, function ($value) {
            return $value !== '' && $value !== "" && $value !== null;
        });

        $response = $this->service->api->request('POST', "https://gissv2-{$this->codMunicipio}.giss.com.br/service-empresa/api/cliente-fornecedor/", [
            'headers' => [
                'Accept'          => 'application/json, text/plain, */*',
                'Accept-Encoding' => 'gzip, deflate, br, zstd',
                'Authorization'   => 'Bearer ' . $this->token,
                'Content-Type'    => 'application/json;charset=UTF-8',
                'Referer'         => 'https://muriae.giss.com.br/',
            ],
            'json' => $json,
        ]);

        return json_decode($response->getBody()->getContents());

    }
    public function update()
    {
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

        return json_decode($response->getBody()->getContents());
    }
}
