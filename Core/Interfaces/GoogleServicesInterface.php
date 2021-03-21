<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 3/21/2021
 * Time: 5:35 PM
 */

namespace Core\Interfaces;


interface GoogleServicesInterface
{
    public function connect();
    public function getData(): array;
    public function setParams();
    public function getParams(): array;
}