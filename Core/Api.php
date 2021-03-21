<?php

namespace Core;

class Api
{
    public function __construct()
    {
        $headers = new Header();

        $headers->originHeaders();

        $headers->JSONHeaders();

        $router = new Router();

        $router->dispatch($_SERVER['QUERY_STRING']);
    }
}