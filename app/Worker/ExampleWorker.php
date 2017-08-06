<?php

namespace App\Worker;

use App\Api\Http\Request;
use App\Api\Http\Response;
use App\Api\Exception\HttpException;
use App\Api\Exception\InvalidJsonException;

class ExampleWorker extends AbstractWorker
{

    protected function configure()
    {
        parent::configure();

        $this->setName('example');
    }

    protected function fire()
    {
        $this->output->write('Hello from: ' . $this->getName(), true);
        
        return self::STATUS_PROCESSED_OK;
    }

    protected function sendRequest(array $productData)
    {
        try {
            $response = $this->client->makeRequest(new Request('/product', $productData));

            switch($response->getCode()) {
                case Response:
                    break;
                default:
                    break;
            }
            
        } catch (InvalidJsonException $ex) {
            
        } catch (HttpException $ex) {
            
        }
    }
}