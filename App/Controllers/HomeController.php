<?php

namespace App\Controllers;

use App\Models\Product;
use App\Services\GoogleServiceA;
use App\Services\GoogleServiceB;
use Core\Controller;
use Core\GoogleServiceHandler;
use Core\Response\JSONResponse;


class HomeController extends Controller
{

    /**
     * @return JSONResponse
     */
    public function indexAction(): JSONResponse
    {
        $product = new Product();

        $handler = new GoogleServiceHandler();

        $handler
            ->aggregateData(new GoogleServiceA())
            ->aggregateData(new GoogleServiceB());
        // ...

        $data = $handler->getAggregatedData();

        return new JSONResponse('indexAction', 200, $data);
    }
}
