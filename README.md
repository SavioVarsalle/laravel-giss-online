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
        'localDownload' => '/home/dev2/Projects/MLC'
    ])->getPdf();
    dump($pdfDownload);

    /**
     * Realiza o download do XML no local designado
     */
    $xmlDownload = $service->nota([
        'token' => $token->access_token,
        'idNota' => $nota->conteudo->idNota,
        'localDownload' => '/home/dev2/Projects/MLC'
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
        'token'                 =>  "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJUSVBPTE9HSU4iOiJVc3VhcmlvU2VuaGEiLCJDT0RJR09fVVNVQVJJTyI6IjI4NjI3IiwiQVBQX0lEIChJTklDSUFMKSI6IjM4NDhhYTI3LTZmNmMtM2I1Mi0zMTdjLWQxNzAwOWQ5YWJmZCIsIkxPR0lOIjoiNjc0OTk4NzI2NTMiLCJJUEFERFJFU1MiOiIxMC4yNi41LjEyIiwiVUlQX0lEIjoiNTI4ZjkyZTEtMWVjNi00MTc4LTlhMWMtMmRjMGUzOTYwMDQ3IiwiQ0NUT0tFTiI6IiIsIm5iZiI6MTcwODgwNDA1NCwiZXhwIjoxNzA4ODMyOTE0LCJpc3MiOiJodHRwOi8vd3d3LmNvZGVjaXBoZXJzLmNvbSIsImF1ZCI6WyJodHRwOi8vd3d3LmNvZGVjaXBoZXJzLmNvbSIsImh0dHA6Ly93d3cuY29kZWNpcGhlcnMuY29tIl0sIkFQUF9JRCI6IjM4NDhhYTI3LTZmNmMtM2I1Mi0zMTdjLWQxNzAwOWQ5YWJmZCIsIlBBUkFNX0xPR0lOIjoiW3tcImlkXCI6MixcInRpcG9cIjpcIkNvZENsaWVudGVcIixcImNoYXZlXCI6XCIwMDAwMlwiLFwidmFsb3JcIjpcIlByZWZlaXR1cmEgZGUgTXVyaWHDqVwifV0iLCJQQVJBTV9QUklWIjoiZW1wcmVzYT0yNTk5MDYifQ.QdD83u109bIIAN3AKWE0fas9dcdrzFRHd9oxTi1zYEw",
        'idEmpresa'             =>  259906,
        'notaTipo'              => 1,
        'notaNumero'            => 7243,
        'idMotivoCancelamento'  => 9
    ])->cancelar();
    dump($cancelar);
```