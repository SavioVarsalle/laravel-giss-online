<?php

namespace SavioVarsalle\LaravelGissOnline\EndPoints;

use SavioVarsalle\LaravelGissOnline\GissOnline;

class Prestador
{
    private GissOnline $service;

    private $codMunicipio;

    private $idEmpresa;

    private $token;

    public function __construct(array $data)
    {
        $this->service      = new GissOnline();
        $this->codMunicipio = data_get($data, 'giss_cod_municipio', '');
        $this->idEmpresa    = data_get($data, 'idEmpresa', '');
        $this->token        = data_get($data, 'token', '');
    }

    public function get()
    {
        $response = $this->service->api->request('GET', "https://gissv2-{$this->codMunicipio}.giss.com.br/service-empresa/api/empresa/{$this->codMunicipio}/{$this->idEmpresa}", [
            'headers' => [
                'Accept'          => 'application/json, text/plain, */*',
                'Accept-Encoding' => 'gzip, deflate, br, zstd',
                'Authorization'   => 'Bearer ' . $this->token,
            ],
        ]);

        return json_decode($response->getBody()->getContents());
    }
}
