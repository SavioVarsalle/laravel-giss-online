<?php

namespace SavioVarsalle\LaravelGissOnline\EndPoints;

use SavioVarsalle\LaravelGissOnline\GissOnline;

class Servico
{
    private GissOnline $service;

    private $token;

    private $codMunicipio;

    private $idEmpresa;

    private $dataServico;

    private $notaTipo;

    private $tipoEmpresa;

    public function __construct(array $data)
    {
        $this->service = new GissOnline;
        $this->codMunicipio =  env('GISS_COD_MUNICIPIO_PRESTADOR');
        $this->token = data_get($data, 'token', null);
        $this->idEmpresa = data_get($data, 'idEmpresa', null);
        $this->dataServico = data_get($data, 'dataServico', null);
        $this->notaTipo = data_get($data, 'notaTipo', 1);
        $this->tipoEmpresa = data_get($data, 'tipoEmpresa', '1');
    }

    public function get()
    {
        $response = $this->service->api->request('POST', "https://gissv2-{$this->codMunicipio}.giss.com.br/service-declaracao/api/nota/passo1", [
            'headers' => [
                'Accept'        => 'application/json, text/plain, */*',
                'Accept-Encoding' => 'gzip, deflate, br, zstd',
                'Authorization' => 'Bearer ' . $this->token,
                'Content-Type' => 'application/json;charset=UTF-8'
            ],
            'json' => [
                'data'          => $this->dataServico,
                'idCliente'     => $this->codMunicipio,
                'idEmpresa'     => $this->idEmpresa,
                'notaTipo'      => $this->notaTipo,
                'tipoEmpresa'   => $this->tipoEmpresa,
            ]
        ]);

        return json_decode($response->getBody()->getContents());
    }
}
