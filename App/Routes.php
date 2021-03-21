<?php

namespace App;

use Core\Router;

class Routes
{
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;

        $this->setRoutes();
    }

    /**
     * Set needed routes for api
     * Use route groups for encapsulation of routes
     *
     * @return void
     */
    private function setRoutes(): void
    {

        $this->router->add('', ['controller' => 'home', 'action' => 'index']);

        //...
    }
}