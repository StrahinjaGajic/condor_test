<?php

namespace Core;


class Api
{
    public function __construct()
    {
        (new Header())->setHeader();

        $router = new Core\Router();
    }
}