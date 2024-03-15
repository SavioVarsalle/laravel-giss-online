<?php

namespace SavioVarsalle\LaravelGissOnline\EndPoints;

use SavioVarsalle\LaravelGissOnline\GissOnline;

class Auth
{
    private GissOnline $service;

    private $username;

    private $password;

    private $codMunicipioprestador;

    public function __construct(array $data = [])
    {
        $this->service               = new GissOnline();
        $this->username              = env('GISS_USERNAME');
        $this->password              = env('GISS_PASSWORD');
        $this->codMunicipioprestador = env('GISS_COD_MUNICIPIO_PRESTADOR');
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
                'Param_login'     => $permission->conteudo->empresas[0]->clienteReferencia->sistemaIntegracao,
                'Param_priv'      => 'empresa=' . $permission->conteudo->empresas[0]->idEmpresa,
                'Codigo_usuario'  => $permission->conteudo->codigoUsuario,
            ],
            'form_params' => [
                'grant_type'    => 'refresh_token',
                'refresh_token' => $token1->access_token,
            ],
        ]);

        $data            = json_decode($response->getBody()->getContents());
        $data->idEmpresa = $permission->conteudo->empresas[0]->idEmpresa;

        return $data;
    }
}
