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

header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
header('Content-type:application/json;charset=utf-8');

/**
 * Routing
 */
$api = new Core\Api();

