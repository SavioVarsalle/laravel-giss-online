<?php

use SavioVarsalle\LaravelGissOnline\GissOnline;

test('Deve retornar o bearer token e o id da empresa.', function () {
    $service = new GissOnline;

    $data = $service->auth()->token();
    var_dump($data);
    expect($data->token_type)->toBe('bearer');
    expect($data->idEmpresa)->toBe(259906);
});
