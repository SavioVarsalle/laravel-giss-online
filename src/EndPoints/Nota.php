<?php

namespace SavioVarsalle\LaravelGissOnline\EndPoints;

use SavioVarsalle\LaravelGissOnline\GissOnline;

class Nota
{
    private GissOnline $service;
    private $token;
    private $codMunicipio;
    private $idEmpresa;
    private $notaTipo;
    private $tipoPrestador;
    private $tipoEmpresa;
    private $idTomador;
    private $tipoTomador;
    private $idServico;
    private $idAtividade;
    private $dataCompetencia;
    private $discriminacaoServico;
    private $outrasRetencoes;
    private $valorServico;
    private $exportacao;
    private $issRetido;
    private $municipioPrestacao;
    private $aliquota;
    private $pis;
    private $cofins;
    private $ir;
    private $inss;
    private $csll;

    private $notaNumero;
    private $idMotivoCancelamento;
    private $idNota;
    private $localDownload;

    public function __construct(array $data)
    {
        $this->service = new GissOnline;
        $this->token = data_get($data, 'token');
        $this->codMunicipio = env('GISS_COD_MUNICIPIO_PRESTADOR');
        $this->idEmpresa = data_get($data, 'idEmpresa');
        $this->notaTipo = data_get($data, 'notaTipo', 0);
        $this->tipoPrestador = data_get($data, 'tipoPrestador');
        $this->tipoEmpresa = data_get($data, 'tipoEmpresa');
        $this->idTomador = data_get($data, 'idTomador');
        $this->tipoTomador = data_get($data, 'tipoTomador');
        $this->idServico = data_get($data, 'idServico');
        $this->idAtividade = data_get($data, 'idAtividade');
        $this->dataCompetencia = data_get($data, 'dataCompetencia');
        $this->discriminacaoServico = data_get($data, 'discriminacaoServico');
        $this->outrasRetencoes = data_get($data, 'outrasRetencoes', 0);
        $this->valorServico = data_get($data, 'valorServico');
        $this->exportacao = data_get($data, 'exportacao');
        $this->issRetido = data_get($data, 'issRetido');
        $this->municipioPrestacao = data_get($data, 'municipioPrestacao');
        $this->aliquota = data_get($data, 'aliquota');
        $this->pis = data_get($data, 'pis', 0);
        $this->cofins = data_get($data, 'cofins', 0);
        $this->ir = data_get($data, 'ir', 0);
        $this->inss = data_get($data, 'inss', 0);
        $this->csll = data_get($data, 'csll', 0);
        $this->notaNumero = data_get($data, 'notaNumero');
        $this->idMotivoCancelamento = data_get($data, 'idMotivoCancelamento');
        $this->idNota = data_get($data, 'idNota');
        $this->localDownload = data_get($data, 'localDownload');
    }

    public function emitir()
    {
        $response = $this->service->api->request('POST', "https://gissv2-{$this->codMunicipio}.giss.com.br/service-declaracao/api/nota/emitir", [
            'headers' => [
                'Accept'        => 'application/json, text/plain, */*',
                'Accept-Encoding' => 'gzip, deflate, br, zstd',
                'Authorization' => 'Bearer ' . $this->token,
                'Content-Type' => 'application/json;charset=UTF-8'
            ],
            'json' => [
                'idCliente'             => $this->codMunicipio,
                'idPrestador'           => $this->idEmpresa,
                'notaTipo'              => $this->notaTipo,
                'tipoPrestador'         => $this->tipoPrestador,
                'tipoEmpresa'           => $this->tipoEmpresa,
                'idTomador'             => $this->idTomador,
                'tipoTomador'           => $this->tipoTomador,
                'idServico'             => $this->idServico,
                'idAtividade'           => $this->idAtividade,
                'competencia'           => $this->dataCompetencia,
                'discriminacaoServico'  => $this->discriminacaoServico,
                'outrasRetencoes'       => $this->outrasRetencoes,
                'valorServico'          => $this->valorServico,
                'exportacao'            => $this->exportacao,
                'issRetido'             => $this->issRetido,
                'municipioPrestacao'    => $this->municipioPrestacao,
                'aliquota'              => $this->aliquota,
                'pis'                   => $this->pis,
                'cofins'                => $this->cofins,
                'ir'                    => $this->ir,
                'inss'                  => $this->inss,
                'csll'                  => $this->csll
            ]
        ]);

        return json_decode($response->getBody()->getContents());
    }

    public function cancelar()
    {
        $response = $this->service->api->request('POST', "https://gissv2-{$this->codMunicipio}.giss.com.br/service-declaracao/api/nota/consulta-nota-cancelamento", [
            'headers' => [
                'Accept'            => 'application/json, text/plain, */*',
                'Accept-Encoding'   => 'gzip, deflate, br, zstd',
                'Authorization'     => 'Bearer ' . $this->token,
                'Content-Type'      => 'application/json;charset=UTF-8'
            ],
            'json' => [
                'idCliente' => $this->codMunicipio,
                'idEmpresa' => $this->idEmpresa,
                'tipo'      => $this->notaTipo,
                'numero'    => $this->notaNumero,
            ]
        ]);

        $dadoConsulta = json_decode($response->getBody()->getContents());

        $response = $this->service->api->request('POST', "https://gissv2-{$this->codMunicipio}.giss.com.br/service-declaracao/api/nota/cancelar", [
            'headers' => [
                'Accept'            => 'application/json, text/plain, */*',
                'Accept-Encoding'   => 'gzip, deflate, br, zstd',
                'Authorization'     => 'Bearer ' . $this->token,
                'Content-Type'      => 'application/json;charset=UTF-8'
            ],
            'json' => [
                'idCliente'             => $this->codMunicipio,
                'idEmpresa'             => $this->idEmpresa,
                'idNota'                => $dadoConsulta->conteudo->notaDetalheLista[0]->idNota,
                'idMotivoCancelamento'  => $this->idMotivoCancelamento
            ]
        ]);


        return json_decode($response->getBody()->getContents());
    }

    public function getPdf()
    {
        $response = $this->service->api->request('GET', "https://gissv2-{$this->codMunicipio}.giss.com.br/service-relatorio/api/relatorio/pdf/{$this->codMunicipio}/nota/{$this->idNota}", [
            'headers' => [
                'Accept'            => 'application/json, text/plain, */*',
                'Accept-Encoding'   => 'gzip, deflate, br',
                'Authorization'     => 'Bearer ' . $this->token
            ],
        ]);

        $file = $response->getBody()->getContents();

        $local = "{$this->localDownload}{$this->idNota}.pdf";

        file_put_contents($local, $file);

        return $response->getStatusCode();
    }

    public function getXml()
    {
        $response = $this->service->api->request('GET', "https://gissv2-{$this->codMunicipio}.giss.com.br/service-relatorio/api/relatorio/xml/{$this->codMunicipio}/nota/{$this->idNota}", [
            'headers' => [
                'Accept'            => 'application/json, text/plain, */*',
                'Accept-Encoding'   => 'gzip, deflate, br',
                'Authorization'     => 'Bearer ' . $this->token
            ],
        ]);

        $file = $response->getBody()->getContents();

        $local = "{$this->localDownload}{$this->idNota}.xml";

        file_put_contents($local, $file);

        return $response->getStatusCode();
    }
}
