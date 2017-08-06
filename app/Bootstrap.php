<?php

namespace App;

use App\Worker\WorkerInterface;
use App\Config\Repository as Config;
use App\Config\Loader\ArrayLoader;
use App\Console\Input\ArgvInput;
use App\Console\Input\InputInterface;
use App\Console\Output\ConsoleOutput;
use App\Console\Output\OutputInterface;

class Bootstrap
{
    /**
     * The Application path.
     * @var string
     */
    protected $applicationPath;

    /**
     * @var Config
     */
    protected $config;

    /**
     * Array of defined workers.
     * @var array
     */
    protected $workers = [];
    
    /**
     * Constructor
     * 
     * @param string $applicationPath
     * @throws \InvalidArgumentException
     */
    public function __construct($applicationPath)
    {
        if (!is_dir($applicationPath)) {
            throw new \InvalidArgumentException('The `$applicationPath` must be a valid application path.');
        }

        $this->applicationPath = rtrim($applicationPath);

        $this->config = new Config(new ArrayLoader($this->applicationPath . '/config/application.php'));
    }

    /**
     * @return string
     */
    public function getApplicationPath(): string
    {
        return $this->applicationPath;
    }

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }

    /**
     * @param WorkerInterface $worker
     * @throws \InvalidArgumentException
     */
    public function addWorker(WorkerInterface $worker)
    {
        $name = $worker->getName();

        if(array_key_exists($name, $this->workers)) {
            throw new \InvalidArgumentException(sprintf('Worker with name `%s` is allready defined', $name));
        }
        
        $this->workers[$name] = $worker;
    }

    public function run(InputInterface $input = null, OutputInterface $output = null)
    {
        if($input == null) {
            $input = new ArgvInput();
        }

        if($output == null) {
            $output = new ConsoleOutput();
        }

        $worker = $this->getWorker($this->getWorkerName($input));

        return $this->runWorker($worker, $input, $output);
    }

    protected function runWorker(WorkerInterface $worker, InputInterface $input, OutputInterface $output)
    {
        return $worker->run($input, $output);
    }

    /**
     * @param string $name
     * @return WorkerInterface
     * 
     * @throws \InvalidArgumentException
     */
    public function getWorker($name)
    {
        if(!array_key_exists($name, $this->workers)) {
            throw new \InvalidArgumentException(sprintf('Worker `%s` is not defined.', $name));
        }

        return $this->workers[$name];
    }

    /**
     * @param InputInterface $input
     * @return string|null
     */
    protected function getWorkerName(InputInterface $input)
    {
        return $input->getFirstArgument();
    }
}