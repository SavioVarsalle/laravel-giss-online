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
        $this->codMunicipio       = data_get($data, 'giss_cod_municipio');
        $this->idEmpresa          = data_get($data, 'idEmpresa', '*');
        $this->token              = data_get($data, 'token', '*');
        $this->cnpjCpf            = data_get($data, 'cnpjCpf', '*');
        $this->bairro             = data_get($data, 'bairro', '*');
        $this->cep                = data_get($data, 'cep', '*', '*');
        $this->cidade             = data_get($data, 'cidade', '*');
        $this->complemento        = data_get($data, 'complemento', '*');
        $this->estado             = data_get($data, 'estado', '*');
        $this->idIbge             = data_get($data, 'idIbge', -1);
        $this->idUfIbge           = data_get($data, 'idUfIbge', -1);
        $this->logradouro         = data_get($data, 'logradouro', '*');
        $this->numero             = data_get($data, 'numero', '*');
        $this->tipoLogradouro     = data_get($data, 'tipoLogradouro', '*');
        $this->apelido            = data_get($data, 'apelido', '*');
        $this->notaTipo           = data_get($data, 'notaTipo', '*');
        $this->email              = data_get($data, 'email', '*', '*');
        $this->exterior           = data_get($data, 'exterior', false);
        $this->nomeFantasia       = data_get($data, 'nomeFantasia', '*');
        $this->razaoSocial        = data_get($data, 'razaoSocial', '*');
        $this->codigoArea         = data_get($data, 'codigoArea', -1);
        $this->telefone           = data_get($data, 'telefone', '*');
        $this->mei                = data_get($data, 'mei', false);
        $this->inscricaoEstadual  = data_get($data, 'inscricaoEstadual', '*');
        $this->inscricaoMunicipal = data_get($data, 'inscricaoMunicipal', '*');
        $this->simplesNacional    = data_get($data, 'simplesNacional', '*');
        $this->idTomador          = data_get($data, 'idTomador', '*');
        $this->ativo              = data_get($data, 'ativo', true);
    }

    public function get()
    {
        $today = now()->toDateString();

        $response = $this->service->api->request('GET', "https://gissv2-{$this->codMunicipio}.giss.com.br/service-empresa/api/cliente-fornecedor/tomador/{$this->codMunicipio}/{$this->idEmpresa}/tipo/1/cliente/{$today}?parametro={$this->cnpjCpf}", [
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
        $endereco = $this->cep != '*' ? [
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

        if ($endereco != null) {
            $endereco = array_filter($endereco, function ($value) {
                return $value != '*' && $value != -1 || $value === true;
                ;
            });
        }

        $telefone = $this->telefone != '*' && $this->codigoArea != -1 ? [
            "codigoArea" => $this->codigoArea,
            "alterado"   => true,
            "telefone"   => $this->telefone,
        ] : null;

        $email = $this->email != '*' ? [
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
            return $value != '*' || $value === true;
            ;
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
        $response = $this->service->api->request('GET', "https://gissv2-{$this->codMunicipio}.giss.com.br/service-empresa/api/cliente-fornecedor/{$this->codMunicipio}/{$this->idTomador}", [
            'headers' => [
                'Accept'          => 'application/json, text/plain, */*',
                'Accept-Encoding' => 'gzip, deflate, br, zstd',
                'Authorization'   => 'Bearer ' . $this->token,
            ],
        ]);

        $data = json_decode($response->getBody()->getContents());

        //dd($data->conteudo->exterior);
        if ($data->codigoHTTP === 200) {
            $endereco = isset($data->conteudo->endereco) ? [
                "idEndereco"       => data_get($data->conteudo->endereco, 'idEndereco', '*'),
                "idCliente"        => data_get($data->conteudo->endereco, 'idCliente', '*'),
                "alterado"         => true,
                "tipo"             => data_get($data->conteudo->endereco, 'tipo', '*'),
                "idIbge"           => $this->checkData(data_get($data->conteudo->endereco, 'idIbge', '*'), $this->idIbge),
                "idUfIbge"         => $this->checkData(data_get($data->conteudo->endereco, 'idUfIbge', '*'), $this->idUfIbge),
                "tipoLogradouro"   => $this->checkData(data_get($data->conteudo->endereco, 'tipoLogradouro', '*'), $this->tipoLogradouro),
                "logradouro"       => $this->checkData(data_get($data->conteudo->endereco, 'logradouro', '*'), $this->logradouro),
                "numero"           => $this->checkData(data_get($data->conteudo->endereco, 'numero', '*'), $this->numero),
                "complemento"      => $this->checkData(data_get($data->conteudo->endereco, 'complemento', '*'), $this->complemento),
                "bairro"           => $this->checkData(data_get($data->conteudo->endereco, 'bairro', '*'), $this->bairro),
                "cep"              => $this->checkData(data_get($data->conteudo->endereco, 'cep', '*'), $this->cep),
                "cidade"           => $this->checkData(data_get($data->conteudo->endereco, 'cidade', '*'), $this->cidade),
                "estado"           => $this->checkData(data_get($data->conteudo->endereco, 'estado', '*'), $this->estado),
                "possuiCoordenada" => data_get($data->conteudo->endereco, 'possuiCoordenada', '*'),
                "possuiArea"       => data_get($data->conteudo->endereco, 'possuiArea', '*'),
                "rural"            => data_get($data->conteudo->endereco, 'rural', '*'),
                "cadastro"         => data_get($data->conteudo->endereco, 'cadastro', '*'),
                "atualizacao"      => now()->format('Y-m-d\TH:i:s.u'),
                "ativo"            => $this->ativo != data_get($data->conteudo->endereco, 'ativo', '*') ? $this->ativo : data_get($data->conteudo->endereco, 'ativo', '*'),
            ] : '*';

            if ($endereco !== '*') {
                $endereco = array_filter($endereco, function ($value) {
                    return $value != '*' && $value != -1 || $value === true;
                });
            }

            $telefone = isset($data->conteudo->telefone) ? [
                "alterado"    => true,
                "idTelefone"  => data_get($data->conteudo->telefone, 'idTelefone', '*'),
                "idCliente"   => data_get($data->conteudo->telefone, 'idCliente', '*'),
                "codigoArea"  => $this->checkData(data_get($data->conteudo->telefone, 'codigoArea', '*'), $this->codigoArea),
                "telefone"    => $this->checkData(data_get($data->conteudo->telefone, 'telefone', '*'), $this->telefone),
                "cadastro"    => data_get($data->conteudo->telefone, 'cadastro', '*'),
                "atualizacao" => now()->format('Y-m-d\TH:i:s.u'),
                "ativo"       => $this->ativo != data_get($data->conteudo->telefone, 'ativo', '*') ? $this->ativo : data_get($data->conteudo->telefone, 'ativo', null),
            ] : '*';

            if ($telefone !== '*') {
                $telefone = array_filter($telefone, function ($value) {
                    return $value != '*' || $value === true;
                });
            }

            $email = isset($data->conteudo->email) || $this->email != '*' ? [
                "alterado"    => true,
                "idEmail"     => data_get($data->conteudo->email, 'idEmail', '*'),
                "idCliente"   => data_get($data->conteudo->email, 'idCliente', '*'),
                "email"       => $this->checkData(data_get($data->conteudo->email, 'email', '*'), $this->email),
                "cadastro"    => data_get($data->conteudo->email, 'cadastro', '*'),
                "atualizacao" => now()->format('Y-m-d\TH:i:s.u'),
                "ativo"       => $this->ativo != data_get($data->conteudo->email, 'ativo', '*') ? $this->ativo : data_get($data->conteudo->email, 'ativo', null),
            ] : '*';

            if ($email !== '*') {
                $email = array_filter($email, function ($value) {
                    return $value != '*' || $value === true;
                });
            }

            $json = [
                "alterado"          => true,
                "id"                => $this->idTomador,
                "idCliente"         => data_get($data->conteudo, 'idCliente'),
                "idEmpresa"         => data_get($data->conteudo, 'idEmpresa'),
                "tipo"              => data_get($data->conteudo, 'tipo'),
                "nomeFantasia"      => $this->checkData(data_get($data->conteudo, 'nomeFantasia', '*'), $this->nomeFantasia),
                "razaoSocial"       => $this->checkData(data_get($data->conteudo, 'razaoSocial', '*'), $data->conteudo->razaoSocial),
                "apelido"           => $this->checkData(data_get($data->conteudo, 'apelido', '*'), $this->apelido),
                "inscricaoEstadual" => $this->checkData(data_get($data->conteudo, 'inscricaoEstadual', '*'), $this->inscricaoEstadual),
                "documento"         => $this->cnpjCpf,
                "exterior"          => data_get($data->conteudo, 'exterior', '*'),
                "tipoDocumento"     => data_get($data->conteudo, 'tipoDocumento', '*'),
                "mei"               => $this->mei != data_get($data->conteudo, 'mei', '*') ? $this->mei : data_get($data->conteudo, 'mei', '*'),
                "simplesNacional"   => data_get($data->conteudo, 'simplesNacional', '*'),
                "email"             => $email,
                "endereco"          => $endereco,
                "telefone"          => $telefone,
                "cadastro"          => data_get($data->conteudo, 'cadastro'),
                "atualizacao"       => now()->format('Y-m-d\TH:i:s.u'),
                "ativo"             => true,
                "tipoEmpresa"       => data_get($data->conteudo, 'tipoEmpresa', '1'),
            ];

            $json = array_filter($json, function ($value) {
                return $value != '*' || $value === true;
            });

            $response = $this->service->api->request('PUT', "https://gissv2-{$this->codMunicipio}.giss.com.br/service-empresa/api/cliente-fornecedor/", [
                'headers' => [
                    'Accept'          => 'application/json, text/plain, */*',
                    'Accept-Encoding' => 'gzip, deflate, br, zstd',
                    'Authorization'   => 'Bearer ' . $this->token,
                    'Content-Type'    => 'application/json;charset=UTF-8',
                ],
                'json' => $json,
            ]);

            return json_decode($response->getBody()->getContents());
        }

        return false;
    }

    private function checkData($old, $new)
    {
        if ($new !== -1 && $new !== '*' && $new != $old) {
            return $new;
        } else {
            return $old;
        }
    }
}
