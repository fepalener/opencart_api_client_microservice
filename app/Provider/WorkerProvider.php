<?php

namespace App\Provider;

use App\Bootstrap;
use App\Api\Client;

class WorkerProvider implements ProviderInterface
{
    /**
     * @param Bootstrap $app
     */
    public function register(Bootstrap $app)
    {
        $workers = $this->getWorkers($app->getApplicationPath());

        $config = $app->getConfig()->get('api');
        $client = new Client($config['url'], $config['key']);
        
        array_walk($workers, function($worker) use($app, $client) {
            $app->addWorker(new $worker($client, $app->getConfig()));
        });
    }

    private function getWorkers($applicationPath)
    {
        return include $applicationPath . '/app/workers.php';
    }
}