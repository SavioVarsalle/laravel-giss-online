# Laravel GissOnline - Serviço de comunicação via api.

## Instalação

Usando o Composer:
```
composer require savio.varsalle/laravel-giss-online
```

## Configuração

No arquivo .env defina as seguintes variáveis:
``` .env
//Código IBGE do município onde o prestador do serviço está localizado.
GISS_COD_MUNICIPIO_PRESTADOR=

//Usuário da plataforma
GISS_USERNAME=

//Senha da plataforma
GISS_PASSWORD=
```

## Exemplo

``` php

    $service = new GissOnline;
    /**
     * Pega o Token e o ID da Empresa
     */
    $token = $service->auth()->token();
    dump($token);

    /**
     * Pega os dados do usuario
     */
    $usuario = $service->usuario([
        'token' => $token->access_token
    ])->get();
    dump($usuario);

    /**
     * Pega os dados do Prestador do Serviço (A Empresa)
     */
    $prestador = $service->prestador([
        'token' => $token->access_token,
        'idEmpresa' => $token->idEmpresa
    ])->get();
    dump($prestador);

    /**
     * Pega os serviços realizados pelo Prestador(A Empresa)
     */
    $servicos = $service->servico([
        'token' => $token->access_token,
        'dataServico' => today()->format('d/m/Y'),
        'idEmpresa' => $token->idEmpresa
    ])->get();
    dump($servicos);

    /**
     * Pega os dados do Tomador do serviço(O Cliente)
     */
    $tomador = $service->tomador([
        'token' => $token->access_token,
        'cnpjCpf' => '48.379.643/0001-14',
        'idEmpresa' => $token->idEmpresa
    ])->get();
    dump($tomador);

    /**
     * Realiza a emissão da Nota
     */
    $nota = $service->nota([
        'token'                 =>  $token->access_token,
        'idEmpresa'             =>  $token->idEmpresa,
        'notaTipo'              => 1,
        'tipoPrestador'         =>  "1",
        'tipoEmpresa'           =>  "1",
        'idTomador'             =>  $tomador->conteudo->idEmpresa,
        'tipoTomador'           =>  $tomador->conteudo->tipoInscricao,
        'idServico'             =>  $servicos->conteudo->servicoAtividade[0]->idServico,
        'idAtividade'           =>  $servicos->conteudo->servicoAtividade[0]->idAtividade,
        'dataCompetencia'       =>  today()->format('d/m/Y'),
        'discriminacaoServico'  =>  "Emissão de teste com pacote no laravel",
        'outrasRetencoes'       =>  0,
        'valorServico'          =>  1.5,
        'exportacao'            =>  false,
        'issRetido'             =>  false,
        'municipioPrestacao'    =>  3143906,
        'aliquota'              =>  3,
        'pis'                   =>  0,
        'cofins'                =>  0,
        'ir'                    =>  0,
        'inss'                  =>  0,
        'csll'                  =>  0,
    ])->emitir();
    dump($nota);

    /**
     * Realiza o download do PDF no local designado
     */
    $pdfDownload = $service->nota([
        'token' => $token->access_token,
        'idNota' => $nota->conteudo->idNota,
        'localDownload' => '/home/dev2/Projects/MLC/'
    ])->getPdf();
    dump($pdfDownload);

    /**
     * Realiza o download do XML no local designado
     */
    $xmlDownload = $service->nota([
        'token' => $token->access_token,
        'idNota' => $nota->conteudo->idNota,
        'localDownload' => '/home/dev2/Projects/MLC/'
    ])->getXml();
    dump($pdfDownload);

    /**
     * Pega os Motivos de Cancelamento disponiveis para o municipio
     */
    $motivoCancelamento = $service->motivoCancelamento([
        'token' => $token->access_token
    ])->list();
    dump($motivoCancelamento);

    /**
     * Cancelar a Nota
     */
    $cancelar = $service->nota([
        'token'                 =>  $token->access_token,
        'idEmpresa'             =>  $token->idEmpresa,
        'notaTipo'              => $nota->conteudo->notaTipo,
        'notaNumero'            => $nota->conteudo->numero,
        'idMotivoCancelamento'  => $motivoCancelamento->conteudo[3]->idMotivoCancelamento
    ])->cancelar();
    dump($cancelar);
```
