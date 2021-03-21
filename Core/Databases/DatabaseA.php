<?php

namespace Core\Databases;

use Core\DB;
use Core\Interfaces\DBInterface;

class DatabaseA extends DB implements DBInterface
{
    /**
     * Class instance
     *
     * @var DB $instance
     */
    private static $instance = null;

    public $conf = [];

    public function __construct()
    {
        $this->setConf();

        parent::__construct($this->getConf());
    }

    public function setConf()
    {
        //We can define configuration in separate file
        $this->conf = [
            'host' => 'localhost',
            'name' => 'condor1',
            'user' => 'root',
            'password' => '',
            'options' => [
                \PDO::ATTR_PERSISTENT => true,
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
            ]
        ];
    }

    public function getConf(): array
    {
        return $this->conf;
    }

    /**
     * Singleton
     *
     * Create object only if instance does't already exists
     *
     * @return DB
     */
    public static function getInstance(): DB
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}