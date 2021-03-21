<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 3/20/2021
 * Time: 1:15 PM
 */

namespace Core;


class Headers
{
    public function __construct()
    {
        $this->originHeaders();

        $this->JSONHeaders();
    }

    /**
     * @return void
     */
    private function originHeaders(): void
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Max-Age: 1000');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization');
    }

    /**
     * @return void
     */
    private function JSONHeaders(): void
    {
        header('Content-type:application/json;charset=utf-8');
        header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
    }
}