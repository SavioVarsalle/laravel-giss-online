<?php

use SavioVarsalle\LaravelGissOnline\GissOnline;

return [
    /**
     * Codigo do municipio de origem do prestador.
     */
    'cod_municipio' => env('GISS_COD_MUNICIPIO_PRESTADOR'),

    /**
     * Dados de login na plataforma do GissOnline.
     */
    'username' => env('GISS_USERNAME', ''),
    'password' => env('GISS_PASSWORD', ''),
];
