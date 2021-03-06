<?php

namespace Core;

use Core\Response\JSONResponse;

/**
 *
 * Base controller
 *
 */
abstract class Controller
{
    /**
     * Parameters from the matched route
     * @var array
     */
    protected $route_params = [];

    /**
     * Class constructor
     *
     * @param array $route_params  Parameters from the route
     *
     * @return void
     */
    public function __construct($route_params)
    {
        $this->route_params = $route_params;
    }

    /**
     * We use this magic method to execute before and after filter methods on action methods.
     * Controller method will be called with suffix Action
     *
     * @param string $name  Method name
     * @param array $args Arguments passed to the method
     *
     * @return void
     * @throws \Exception
     */
    public function __call(string $name, array $args): void
    {
        $method = $name . 'Action';

        if (!method_exists($this, $method)) {
            //Log "Method $method not found in controller " . get_class($this)

            new JSONResponse('Method not found', 400);
        }
        if ($this->before()) {
            call_user_func_array([$this, $method], $args);
            $this->after();
        }
    }

    /**
     * Before filter - called before an action method.
     *
     * @return bool
     */
    protected function before(): bool
    {
        //Handle whole request easier,etc. prevent some ip address to access database or some other logic
        return true;
    }

    /**
     * After filter - called after an action method.
     *
     * @return void
     */
    protected function after(): void
    {
        //Remove token from some user
    }
}
