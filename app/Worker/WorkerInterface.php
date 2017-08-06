<?php

namespace App\Worker;

use App\Console\Input\InputInterface;
use App\Console\Output\OutputInterface;

interface WorkerInterface
{

    public function getName();

    public function run(InputInterface $input, OutputInterface $output);
}