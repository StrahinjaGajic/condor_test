<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 3/20/2021
 * Time: 1:15 PM
 */

namespace Core;


class Header
{
    public function __construct()
    {
        $this->setHeader();
    }

    /**
     * @return void
     */
    public function setHeader(): void
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Max-Age: 1000');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization');
    }
}