<?php

namespace SavioVarsalle\LaravelGissOnline\EndPoints;

use SavioVarsalle\LaravelGissOnline\GissOnline;

class Auth
{
    private GissOnline $service;

    private $username;

    private $password;

    private $codMunicipioprestador;

    private $cnpj;

    public function __construct(array $data)
    {
        $this->service               = new GissOnline();
        $this->username              = data_get($data, 'giss_username');
        $this->password              = data_get($data, 'giss_password');
        $this->codMunicipioprestador = data_get($data, 'giss_cod_municipio');
        $this->cnpj                  = data_get($data, 'cnpj');
    }

    public function token()
    {
        $response = $this->service->api->request('POST', "https://gissv2-{$this->codMunicipioprestador}.giss.com.br/service-empresa/api/login/token", [
            'headers' => [
                'Content-Type'    => 'application/x-www-form-urlencoded',
                'App_id'          => '3848aa27-6f6c-3b52-317c-d17009d9abfd',
                'Accept'          => 'application/json, text/plain, */*',
                'Accept-Encoding' => 'gzip, deflate, br, zstd',
                'Accept-Language' => 'en-US,en;q=0.9,pt-BR;q=0.8,pt;q=0.7',
                'Param_user'      => 'CodCliente',
                'Origin'          => 'https://muriae.giss.com.br',
                'Referer'         => 'https://muriae.giss.com.br/',
            ],
            'form_params' => [
                'grant_type'         => 'password',
                'username'           => $this->username,
                'password'           => $this->password,
                'tipoLogin'          => 0,
                'idParametroInicial' => 2,
            ],
        ]);

        $token1 = json_decode($response->getBody()->getContents());

        $response = $this->service->api->request('GET', "https://gissv2-{$this->codMunicipioprestador}.giss.com.br/service-empresa/api/login/permissao", [
            'headers' => [
                'Accept'          => 'application/json, text/plain, */*',
                'Accept-Encoding' => 'gzip, deflate, br, zstd',
                'Authorization'   => 'Bearer ' . $token1->access_token,
            ],
        ]);

        $permission = json_decode($response->getBody()->getContents());

        $empresa = collect($permission->conteudo->empresas)->firstWhere('documento', $this->cnpj);

        $response = $this->service->api->request('POST', "https://gissv2-{$this->codMunicipioprestador}.giss.com.br/service-empresa/api/login/token", [
            'headers' => [
                'Content-Type'    => 'application/x-www-form-urlencoded',
                'App_id'          => '3848aa27-6f6c-3b52-317c-d17009d9abfd',
                'Accept'          => 'application/json, text/plain, */*',
                'Accept-Encoding' => 'gzip, deflate, br, zstd',
                'Accept-Language' => 'en-US,en;q=0.9,pt-BR;q=0.8,pt;q=0.7',
                'Param_user'      => 'CodCliente',
                'Origin'          => 'https://muriae.giss.com.br',
                'Referer'         => 'https://muriae.giss.com.br/',
                'Param_login'     => (int) $empresa->clienteReferencia,
                'Param_priv'      => 'empresa=' . $empresa->idEmpresa,
                'Codigo_usuario'  => $permission->conteudo->codigoUsuario,
            ],
            'form_params' => [
                'grant_type'    => 'refresh_token',
                'refresh_token' => $token1->access_token,
            ],
        ]);

        $data            = json_decode($response->getBody()->getContents());
        $data->idEmpresa = $empresa->idEmpresa;

        return $data;
    }
}
