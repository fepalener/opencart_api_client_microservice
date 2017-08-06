<?php

if (version_compare('7.0.0', PHP_VERSION, '>')) {
    fwrite(
        STDERR,
        sprintf(
            'This version of API is supported on PHP 7.0 and PHP 7.1' . PHP_EOL .
            'You are using PHP %s (%s).' . PHP_EOL,
            PHP_VERSION,
            PHP_BINARY
        )
    );

    exit;
}

require __DIR__ . '/../vendor/autoload.php';

use App\Bootstrap;

$providers = [
    new App\Provider\WorkerProvider
];

$app = new Bootstrap(dirname(dirname(__FILE__)));

array_walk($providers, function($provider) use($app) {
    $provider->register($app);
});

return $app;