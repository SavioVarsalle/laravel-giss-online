<?php

namespace SavioVarsalle\LaravelGissOnline;

use GuzzleHttp\Client;
use SavioVarsalle\LaravelGissOnline\EndPoints\Auth;

class GissOnline
{
    public $api;

    public function __construct()
    {
        $codMunicipioprestador = config('gissonline.cod_municipio', '3143906');

        $this->api = new Client([
            'base_url' => "https://gissv2-{$codMunicipioprestador}.giss.com.br/"
        ]);
    }

    public function auth()
    {
        return new Auth;
    }

    public function prestador()
    {
        //
    }
}
