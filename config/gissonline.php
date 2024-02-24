<?php

use SavioVarsalle\LaravelGissOnline\GissOnline;

return [
    /**
     * Codigo do municipio de origem do prestador.
     */
    'cod_municipio' => env('GISS_COD_MUNICIPIO_PRESTADOR', '3143906'),

    /**
     * Dados de login na plataforma do GissOnline.
     */
    'username' => env('GISS_USERNAME', '67499872653'),
    'password' => env('GISS_PASSWORD', 'G54QU8XD'),
];
