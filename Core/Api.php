<?php

namespace Core;


class Api
{
    public function __construct()
    {
        (new Header())->setHeader();

        $router = new Router();

        $router->add('', ['controller' => 'home', 'action' => 'index']);

        $router->dispatch($_SERVER['QUERY_STRING']);
    }
}