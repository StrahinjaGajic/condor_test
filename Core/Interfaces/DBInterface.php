<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 3/21/2021
 * Time: 12:33 PM
 */

namespace Core\Interfaces;

use Core\DB;

interface DBInterface
{
    public static function getInstance(): DB;
    public function setConf();
    public function getConf();
}