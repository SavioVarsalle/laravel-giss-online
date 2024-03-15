<?php

namespace SavioVarsalle\LaravelGissOnline\EndPoints;

use SavioVarsalle\LaravelGissOnline\GissOnline;

class MotivoCancelamento
{
    private GissOnline $service;

    private $token;

    private $codMunicipio;

    public function __construct(array $data)
    {
        $this->service      = new GissOnline();
        $this->token        = data_get($data, 'token');
        $this->codMunicipio = data_get($data, 'giss_cod_municipio');
    }

    public function list()
    {
        $response = $this->service->api->request('GET', "https://gissv2-{$this->codMunicipio}.giss.com.br/service-cliente/api/motivo-cancelamento/listar/{$this->codMunicipio}", [
            'headers' => [
                'Accept'          => 'application/json, text/plain, */*',
                'Accept-Encoding' => 'gzip, deflate, br',
                'Authorization'   => 'Bearer ' . $this->token,
            ],
        ]);

        return json_decode($response->getBody()->getContents());
    }
}
