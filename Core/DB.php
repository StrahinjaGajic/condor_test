<?php

namespace Core;

class DB
{
    /**
     * @var \PDO $pdo
     */
    protected $pdo;

    /**
     * @var \PDO $stmt statement
     */
    private $stmt;

    /**
     * Model name
     *
     * @var null|string $currentModel
     */
    private $currentModel = null;

    /**
     * Create database instance
     *
     * Database connection details are taken from Config
     * @param array $databaseConf
     */
    public function __construct(array $databaseConf)
    {
        list(
            'host' => $host,
            'name' => $name,
            'user' => $user,
            'password' => $password,
            'options' => $options
        ) = $databaseConf;

        $params = 'mysql:host=' . $host . ';dbname=' . $name . ';charset=utf8';

        $this->pdo = new \PDO($params, $user, $password, $options);
    }

    /**
     * Make prepared statement
     *
     * @param $sql
     * @return $this
     */
    public function query($sql){
        $this->stmt = $this->pdo->prepare($sql);

        return $this;
    }

    /**
     * Bind params to prepared statement if needed
     *
     * @param $param
     * @param $value
     * @param null $type
     * @return $this
     */
    public function bind($param, $value, $type = null){
        if(is_null($type)){
            switch(true){
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOLL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }

        $this->stmt->bindValue($param, $value, $type);

        return $this;
    }

    /**
     * Execute prepared statement
     *
     * @return mixed
     */
    public function execute(){
        return $this->stmt->execute();
    }

    /**
     * Get all rows as objects
     *
     * @return null | array [objects]
     */
    public function get()
    {
        $this->setClassFetchMode();

        $this->execute();

        return $this->stmt->fetchAll();
    }

    /**
     * Get single row as object
     *
     * @return null | object
     */
    public function single()
    {
        $this->setClassFetchMode();

        $this->execute();

        return $this->stmt->fetch();
    }

    /**
     * Count rows
     *
     * @return integer
     */
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    /**
     *
     * Set PDO fetch mode into specific class
     *
     */
    private function setClassFetchMode()
    {
        $this->stmt->setFetchMode(PDO::FETCH_CLASS, $this->currentModel);
    }

    /**
     * Set current model name.
     * We use this name for fetch mode.
     *
     * @param $model
     */
    public function setCurrentModelName(string $model): void
    {
        $this->currentModel = $model;
    }
}