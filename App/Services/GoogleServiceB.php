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

    /**
     * Connect with guzzle to some service based on params
     */
    public function connect()
    {
        $params = $this->getParams();
        $this->connection = true;
    }

    /**
     * Check response from service
     * Log errors
     * Return data if every condition is met
     *
     * @return array
     */
    public function getData(): array
    {
        //Get data from service based on params, register any method to handle data
        $dataFromService = [
            'something' => 'anything',
            'selflessness' => 'understanding'
        ];

        return [
            'googleServiceB' => $dataFromService
        ];
    }

    /**
     * Set params for connection to service
     */
    public function setParams()
    {
        $this->params = [

        ];
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    //Define addition methods based on service for handling of data
}