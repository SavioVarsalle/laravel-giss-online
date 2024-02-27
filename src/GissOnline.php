<?php

namespace SavioVarsalle\LaravelGissOnline;

use GuzzleHttp\Client;
use SavioVarsalle\LaravelGissOnline\EndPoints\{Auth, MotivoCancelamento, Nota, Prestador, Servico, Tomador, Usuario};

class GissOnline
{
    public $api;

    public function __construct()
    {
        $this->api = new Client();
    }

    public function auth(array $data = [])
    {
        return new Auth($data);
    }

    public function prestador(array $data)
    {
        return new Prestador($data);
    }

    public function tomador(array $data)
    {
        return new Tomador($data);
    }

    public function usuario(array $data)
    {
        return new Usuario($data);
    }

    public function servico(array $data)
    {
        return new Servico($data);
    }

    public function motivoCancelamento(array $data)
    {
        return new MotivoCancelamento($data);
    }

    public function nota(array $data)
    {
        return new Nota($data);
    }
}
