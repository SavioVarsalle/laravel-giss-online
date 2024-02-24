<?php

namespace SavioVarsalle\LaravelGissOnline\EndPoints;

use SavioVarsalle\LaravelGissOnline\GissOnline;

class Tomador
{
    private GissOnline $service;

    private $codMunicipio;

    private $idEmpresa;

    private $token;

    private $cnpjCpf;

    public function __construct(array $data)
    {
        $this->service      = new GissOnline;
        $this->codMunicipio = env('GISS_COD_MUNICIPIO_PRESTADOR');
        $this->idEmpresa    = data_get($data, 'idEmpresa', '') ;
        $this->token        = data_get($data, 'token', '');
        $this->cnpjCpf = data_get($data, 'cnpjCpf', null);
    }

    public function get()
    {
        $response = $this->service->api->request('GET', "https://gissv2-{$this->codMunicipio}.giss.com.br/service-empresa/api/cliente-fornecedor/tomador/{$this->codMunicipio}/{$this->idEmpresa}/tipo/1/cliente/2024-02-23?parametro={$this->cnpjCpf}", [
            'headers' => [
                'Accept'        => 'application/json, text/plain, */*',
                'Accept-Encoding' => 'gzip, deflate, br, zstd',
                'Authorization' => 'Bearer ' . $this->token
            ],
        ]);
        $dadosBasicos = json_decode($response->getBody()->getContents());
        
        $response = $this->service->api->request('GET', "https://gissv2-{$this->codMunicipio}.giss.com.br/service-empresa/api/empresa/endereco/{$this->codMunicipio}/{$dadosBasicos->conteudo[0]->id}", [
            'headers' => [
                'Accept'        => 'application/json, text/plain, */*',
                'Accept-Encoding' => 'gzip, deflate, br, zstd',
                'Authorization' => 'Bearer ' . $this->token
            ],
        ]);
        
        return json_decode($response->getBody()->getContents());
    }
}