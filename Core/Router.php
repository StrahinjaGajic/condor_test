<?php

namespace Core;

use App\Routes;
use Core\Response\JSONResponse;

/**
 *
 * Router
 *
 */
class Router
{
    /**
     * Associative array of routes (the routing table)
     * @var array
     */
    protected $routes = [];

    /**
     * Parameters from the matched route
     * @var array
     */
    protected $params = [];

    /**
     * Controller name
     *
     * @var string $controllerName
     */
    private $controllerName = '';

    /**
     * @var string $url
     */
    private $url;

    public function __construct()
    {
        (new Routes($this));
        (new ValidateApiRequest($_REQUEST));
    }

    /**
     * Get all the routes from the routing table
     *
     * @return array
     */
    protected function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * Get the currently matched parameters
     *
     * @return array
     */
    protected function getParams(): array
    {
        return $this->params;
    }

    /**
     * Get the namespace for the controller class. The namespace defined in the
     * route parameters is added if present.
     *
     * @return string The request URL
     */
    private function getNamespace(): string
    {
        $namespace = 'App\Controllers\\';

        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'] . '\\';
        }
        return $namespace;
    }

    /**
     * @return string
     */
    private function getControllerName(): string
    {
        return $this->controllerName;
    }

    /**
     * @param string $controller
     * @return self
     */
    private function setControllerName(string $controller): self
    {
        $this->controllerName = $controller;

        return $this;
    }

    /**
     * Add a route to the routing table
     *
     * @param string $route The route URL
     * @param array $params Parameters (controller, action, etc.)
     *
     * @return void
     */
    final public function add(string $route, $params = []): void
    {
        // Convert the route to a regular expression: escape forward slashes
        $route = preg_replace('/\//', '\\/', $route);

        // Convert variables e.g. {controller}
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);

        // Convert variables with custom regular expressions e.g. {id:\d+}
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

        // Add start and end delimiters, and case insensitive flag
        $route = '/^' . $route . '$/i';

        $this->routes[$route] = $params;
    }
    /**
     * Dispatch the route, creating the controller object and running the
     * action method
     *
     * @param string $url
     *
     * @return void|JSONResponse
     */
    final public function dispatch(string $url)
    {
        $this->removeQueryStringVariables($url)
            ->match()
            ->setControllerName($this->params['controller'])
            ->formatControllerName();

        if (!class_exists($this->getControllerName())) {
            new JSONResponse('Action not allowed', 403);
        }

        $action = $this->convertToCamelCase($this->params['action']);

        if (!preg_match('/action$/i', $action) == 0) {
            new JSONResponse('Action not allowed', 403);
        }

        $controller_object = new ($this->getControllerName())($this->getParams());

        $controller_object->$action();
    }

    /**
     * Remove the query string variables from the URL (if any). As the full
     * query string is used for the route, any variables at the end will need
     * to be removed before the route is matched to the routing table. For
     * example:
     *
     *   URL                           $_SERVER['QUERY_STRING']  Route
     *   -------------------------------------------------------------------
     *   localhost                     ''                        ''
     *   localhost/?                   ''                        ''
     *   localhost/?page=1             page=1                    ''
     *   localhost/posts?page=1        posts&page=1              posts
     *   localhost/posts/index         posts/index               posts/index
     *   localhost/posts/index?page=1  posts/index&page=1        posts/index
     *
     * A URL of the format localhost/?page (one variable name, no value) won't
     * work however. (NB. The .htaccess file converts the first ? to a & when
     * it's passed through to the $_SERVER variable).
     *
     * @param string $url The full URL
     *
     * @return self
     */
    private function removeQueryStringVariables(string $url): self
    {
        if ($url != '') {
            $parts = explode('&', $url, 2);

            if (strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }

        $this->url = $url;

        return $this;
    }

    /**
     * Match the route to the routes in the routing table, setting the $params
     * property if a route is found.
     *
     * @return self|JSONResponse
     */
    private function match()
    {
        foreach ($this->routes as $route => $params) {

            if (preg_match($route, $this->url, $matches)) {
                // Get named capture group values
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }
                $this->params = $params;
                return $this;
            }
        }

        new JSONResponse('Route not found', 404);
    }

    /**
     * Format controller from url
     */
    private function formatControllerName()
    {
        $this->convertControllerToStudlyCase()
        ->addControllerSuffix()
        ->setControllerNamespace();
    }

    /**
     * Add suffix to class
     *
     * @return self
     */
    private function addControllerSuffix(): self
    {
        $this->setControllerName($this->getControllerName() . 'Controller');

        return $this;
    }

    /**
     * Convert the string with hyphens to camelCase,
     * e.g. add-new => addNew
     *
     * @param string $value The string to convert
     *
     * @return string
     */
    private function convertToCamelCase(string $value): string
    {
        return lcfirst(convertToStudlyCaps($value));
    }

    /**
     * @inheritdoc from convertToStudlyCaps()
     *
     * @return self
     */
    private function convertControllerToStudlyCase(): self
    {
        $this->setControllerName(convertToStudlyCaps($this->getControllerName()));

        return $this;
    }

    /**
     * @return void
     */
    private function setControllerNamespace(): void
    {
        $this->setControllerName($this->getNamespace() . $this->getControllerName());
    }
}
