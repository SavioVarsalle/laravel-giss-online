<?php

use SavioVarsalle\LaravelGissOnline\GissOnline;

/*
test('Deve retornar o bearer token e o id da empresa.', function () {
    $service = new GissOnline();

    $data = $service->auth([
        'giss_cod_municipio' => 3143906,
        'giss_username'      => "12883103666",
        'giss_password'      => "Loja123@",
    ])->token();
    var_dump($data);
    expect($data->token_type)->toBe('bearer');
    expect($data->idEmpresa);
});

test('Deve cadastrar o cliente CNPJ, retornar o codigo http 200 e os dados de cadastro.', function () {
    $service = new GissOnline();

    $cadastroCNPJ = $service->tomador([
        'token'              => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJUSVBPTE9HSU4iOiJVc3VhcmlvU2VuaGEiLCJDT0RJR09fVVNVQVJJTyI6IjI4NjI3IiwiQVBQX0lEIChJTklDSUFMKSI6IjM4NDhhYTI3LTZmNmMtM2I1Mi0zMTdjLWQxNzAwOWQ5YWJmZCIsIkxPR0lOIjoiNjc0OTk4NzI2NTMiLCJJUEFERFJFU1MiOiIxMC4yNi4yMC4yMDIiLCJVSVBfSUQiOiI1MjhmOTJlMS0xZWM2LTQxNzgtOWExYy0yZGMwZTM5NjAwNDciLCJDQ1RPS0VOIjoiIiwibmJmIjoxNzEwNTEzMzA1LCJleHAiOjE3MTA1NDIxNjUsImlzcyI6Imh0dHA6Ly93d3cuY29kZWNpcGhlcnMuY29tIiwiYXVkIjpbImh0dHA6Ly93d3cuY29kZWNpcGhlcnMuY29tIiwiaHR0cDovL3d3dy5jb2RlY2lwaGVycy5jb20iXSwiQVBQX0lEIjoiMzg0OGFhMjctNmY2Yy0zYjUyLTMxN2MtZDE3MDA5ZDlhYmZkIiwiUEFSQU1fTE9HSU4iOiJbe1wiaWRcIjoyLFwidGlwb1wiOlwiQ29kQ2xpZW50ZVwiLFwiY2hhdmVcIjpcIjAwMDAyXCIsXCJ2YWxvclwiOlwiUHJlZmVpdHVyYSBkZSBNdXJpYcOpXCJ9XSIsIlBBUkFNX1BSSVYiOiJlbXByZXNhPTI1OTkwNiJ9.6WhTJed6SFte2_9QHCbDONsuah80O1uIMytDQKujb2k',
        'exterior'           => false,
        'cep'                => '36700052',
        'estado'             => 'MG',
        'complemento'        => 'LOJA B',
        'logradouro'         => 'R PRESIDENTE',
        'bairro'             => 'CENTRO',
        'idIbge'             => '3138401',
        'idUfIbge'           => '31',
        'tipoLogradouro'     => 'RUA',
        'cidade'             => 'LEOPOLDINA',
        'numero'             => '27',
        'razaoSocial'        => 'COMERCIO DE ARTIGOS DO VESTUARIO LTDA',
        "nomeFantasia"       => 'COMERCIO',
        'cnpjCpf'            => '55099165000154',
        'inscricaoEstadual'  => '41125411111',
        'codigoArea'         => 31,
        'telefone'           => '999999999',
        'idEmpresa'          => '259906',
        'giss_cod_municipio' => '3143906',
    ])->create();

    expect($cadastroCNPJ->codigoHTTP)->toBe(200);
    expect($cadastroCNPJ->conteudo->id);
});

test('Deve cadastrar o cliente CPF, retornar o codigo http 200 e os dados de cadastro.', function () {
    $service = new GissOnline();

    $cadastroCPF = $service->tomador([
        'token'              => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJUSVBPTE9HSU4iOiJVc3VhcmlvU2VuaGEiLCJDT0RJR09fVVNVQVJJTyI6IjI4NjI3IiwiQVBQX0lEIChJTklDSUFMKSI6IjM4NDhhYTI3LTZmNmMtM2I1Mi0zMTdjLWQxNzAwOWQ5YWJmZCIsIkxPR0lOIjoiNjc0OTk4NzI2NTMiLCJJUEFERFJFU1MiOiIxMC4yNi4xNi4xOTciLCJVSVBfSUQiOiI1MjhmOTJlMS0xZWM2LTQxNzgtOWExYy0yZGMwZTM5NjAwNDciLCJDQ1RPS0VOIjoiIiwibmJmIjoxNzA5MDQ1MTMzLCJleHAiOjE3MDkwNzM5OTMsImlzcyI6Imh0dHA6Ly93d3cuY29kZWNpcGhlcnMuY29tIiwiYXVkIjpbImh0dHA6Ly93d3cuY29kZWNpcGhlcnMuY29tIiwiaHR0cDovL3d3dy5jb2RlY2lwaGVycy5jb20iXSwiQVBQX0lEIjoiMzg0OGFhMjctNmY2Yy0zYjUyLTMxN2MtZDE3MDA5ZDlhYmZkIiwiUEFSQU1fTE9HSU4iOiJbe1wiaWRcIjoyLFwidGlwb1wiOlwiQ29kQ2xpZW50ZVwiLFwiY2hhdmVcIjpcIjAwMDAyXCIsXCJ2YWxvclwiOlwiUHJlZmVpdHVyYSBkZSBNdXJpYcOpXCJ9XSIsIlBBUkFNX1BSSVYiOiJlbXByZXNhPTI1OTkwNiJ9.tQCo0jdh2zioP34oMnveQxICxlpkPOIdeU-18pG4504",
        'exterior'           => false,
        'cep'                => '36884002',
        'estado'             => 'MG',
        'complemento'        => 'Loja',
        'logradouro'         => 'Avenida Doutor lemos',
        'bairro'             => 'CENTRO',
        'idIbge'             => '3143906',
        'idUfIbge'           => '31',
        'tipoLogradouro'     => 'RUA',
        'cidade'             => 'MURIAÉ',
        'numero'             => '108',
        'razaoSocial'        => 'Daniele Torres',
        "apelido"            => 'Daniele',
        'cnpjCpf'            => '78104045040',
        'idEmpresa'          => '259906',
        'giss_cod_municipio' => '3143906',
    ])->create();

    expect($cadastroCPF->codigoHTTP)->toBe(200);
    expect($cadastroCPF->conteudo->id);
});
*/
test('Deve editar o cadastro do cliente, retornar o codigo http 200 e os dados do cliente.', function () {
    $service = new GissOnline();

    $update = $service->tomador([
        "token"              => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJUSVBPTE9HSU4iOiJVc3VhcmlvU2VuaGEiLCJDT0RJR09fVVNVQVJJTyI6IjI4NTI2IiwiQVBQX0lEIChJTklDSUFMKSI6IjM4NDhhYTI3LTZmNmMtM2I1Mi0zMTdjLWQxNzAwOWQ5YWJmZCIsIkxPR0lOIjoiMTI4ODMxMDM2NjYiLCJJUEFERFJFU1MiOiIxMC4yNi41LjEyNCIsIlVJUF9JRCI6ImVmNjBiYTAyLTZlMjAtNDUyNS04Yjg2LTA3Y2U2ZDBhODgwZCIsIkNDVE9LRU4iOiIiLCJuYmYiOjE3MTY5MTg2OTIsImV4cCI6MTcxNjk0NzU1MiwiaXNzIjoiaHR0cDovL3d3dy5jb2RlY2lwaGVycy5jb20iLCJhdWQiOlsiaHR0cDovL3d3dy5jb2RlY2lwaGVycy5jb20iLCJodHRwOi8vd3d3LmNvZGVjaXBoZXJzLmNvbSJdLCJBUFBfSUQiOiIzODQ4YWEyNy02ZjZjLTNiNTItMzE3Yy1kMTcwMDlkOWFiZmQiLCJQQVJBTV9MT0dJTiI6Ilt7XCJpZFwiOjIsXCJ0aXBvXCI6XCJDb2RDbGllbnRlXCIsXCJjaGF2ZVwiOlwiMDAwMDJcIixcInZhbG9yXCI6XCJQcmVmZWl0dXJhIGRlIE11cmlhw6lcIn1dIiwiUEFSQU1fUFJJViI6ImVtcHJlc2E9MjY5MDgxIn0.1fGU4VN5CpkPNwoM4eEERTiYzhSmxRk6inw4hHCOT38",
        "idTomador"          => 327748,
        "apelido"            => "PREFEITURA MUNICIPAL DE MURIAE T" ,
        "cnpjCpf"            => "17947581000176" ,
        "bairro"             => "Centro" ,
        "cep"                => "36880002" ,
        "cidade"             => "Muriaé" ,
        "complemento"        => "-" ,
        "estado"             => "MG" ,
        "idIbge"             => "3143906" ,
        "idUfIbge"           => 31 ,
        "logradouro"         => "Avenida Maestro Sansao alterado" ,
        "numero"             => "1236512626" ,
        "tipoLogradouro"     => "Ave" ,
        "exterior"           => false ,
        "idEmpresa"          => 269081 ,
        "descontoIncondicionado"
        "nomeFantasia"       => "PREFEITURA MUNICIPAL DE MURIAE" ,
        "razaoSocial"        => "PREFEITURA MUNICIPAL DE MURIAE" ,
        "inscricaoEstadual"  => "" ,
        "inscricaoMunicipal" => "300866" ,
        "codigoArea"         => "32" ,
        "telefone"           => "37291020" ,
        "mei"                => false ,
        "giss_cod_municipio" => "3143906",
    ])->update();
    var_dump($update);
    expect($update->codigoHTTP)->toBe(200);
    expect($update->conteudo->id);
});
