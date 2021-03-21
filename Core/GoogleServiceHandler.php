<?php

namespace Core;

use Core\Interfaces\GoogleServicesInterface;

class GoogleServiceHandler
{
    public $data;

    public function __construct()
    {
        //Example response
        $this->data = [
            'error' => false,
            'message' => '',
            'data' => []
        ];
    }

    /**
     * Aggregate service data based on some condition
     *
     * @param GoogleServicesInterface $service
     * @return object
     */
    public function aggregateData(GoogleServicesInterface $service): object
    {
        $data = $service->getData();

        array_push($this->data['data'], $data);

        return $this;
    }

    public function getAggregatedData()
    {
        return $this->data;
    }
}