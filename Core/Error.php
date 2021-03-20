<?php

namespace Core;

use Core\Response\JSONResponse;

/**
 *
 * Error and exception handler
 *
 */
class Error
{

    /**
     * Error handler. Convert all errors to Exceptions by throwing an ErrorException.
     *
     * @param int $level  Error level
     * @param string $message  Error message
     * @param string $file  Filename the error was raised in
     * @param int $line  Line number in the file
     *
     * @return JSONResponse
     */
    public static function errorHandler(int $level, string $message, string $file, int $line): JSONResponse
    {
        //Log error

        return new JSONResponse('Ups, no data for you!',500);
    }

    /**
     * Exception handler.
     *
     * @param \Exception $exception  The exception
     *
     * @return JSONResponse
     */
    public static function exceptionHandler($exception): JSONResponse
    {
        //Log error

        return new JSONResponse('Ups, no data for you!',500);
    }
}
