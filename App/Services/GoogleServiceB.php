<?php
namespace App\Services;

use Core\Interfaces\GoogleServicesInterface;

class GoogleServiceB implements GoogleServicesInterface
{
    private $connection;
    private $params = [];

    public function __construct()
    {
        $this->connect();

        $this->setParams();
    }

    public function connect()
    {
        // Connect with guzzle to some service based on params
        $params = $this->getParams();
        $this->connection = true;
    }

    public function getData(): array
    {
        //Get data from service based on params
        $dataFromService = [
            'something' => 'anything',
            'selflessness' => 'understanding'
        ];

        return [
            'googleServiceB' => $dataFromService
        ];
    }

    public function setParams()
    {
        $this->params = [

        ];
    }

    public function getParams(): array
    {
        return $this->params;
    }
}