<?php

namespace Core;

class Api
{
    public function __construct()
    {
        (new Headers());

        $router = new Router();

        $router->dispatch($_SERVER['QUERY_STRING']);
    }
}