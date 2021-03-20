<?php

/**
 * Front controller
 */

/**
 * Composer
 */
require dirname(__DIR__) . '/vendor/autoload.php';

/**
 * Helper functions
 */
require_once dirname(__DIR__) . '/Helper/helper.php';

/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

/**
 * Routing
 */

$api = new Core\Api();

$router = new Core\Router();

// Add the routes
$router->add('', ['controller' => 'home', 'action' => 'index']);

$router->add('comment/store', ['controller' => 'comment', 'action' => 'store']);

$router->add('admin', ['controller' => 'admin', 'action' => 'index']);

$router->add('admin/login', ['controller' => 'admin', 'action' => 'login']);

$router->add('admin/showCommentList', ['controller' => 'admin', 'action' => 'show-comment-list']);

$router->add('admin/enable/comment', ['controller' => 'admin', 'action' => 'enable-comment']);

$router->add('admin/disable/comment', ['controller' => 'admin', 'action' => 'disable-comment']);

$router->add('admin/logout', ['controller' => 'admin', 'action' => 'logout']);
    
$router->dispatch($_SERVER['QUERY_STRING']);
