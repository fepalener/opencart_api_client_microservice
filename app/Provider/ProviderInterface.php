<?php

namespace App\Provider;

use App\Bootstrap;

interface ProviderInterface
{

    public function register(Bootstrap $app);
}