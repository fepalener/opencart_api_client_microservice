<?php

namespace App\Worker;

use App\Api\Client;
use App\Config\Repository as Config;
use App\Console\Input\InputInterface;
use App\Console\Output\OutputInterface;

abstract class AbstractWorker implements WorkerInterface
{
    const STATUS_PROCESSED_OK    = 1;
    
    const STATUS_PROCESSED_ERROR = 0;
    
    /**
     * @var string
     */
    private $name;

    /**
     * @var Client
     */
    protected $client;
    
    /**
     * @var Config
     */
    protected $config;
    
    /**
     * @var InputInterface
     */
    protected $input;

    /**
     * @var OutputInterface
     */
    protected $output;

    public function __construct(Client $client, Config $config, $name = null)
    {
        $this->client = $client;
        $this->config = $config;
        
        if (null !== $name) {
            $this->setName($name);
        }

        $this->configure();

        if (!$this->name) {
            throw new \LogicException(sprintf('The worker defined in `%s` cannot have an empty name.', get_class($this)));
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->validateName($name);

        $this->name = $name;
    }

    /**
     *
     * It must contain only alphanumeric characters
     *
     * @param string $name
     * @throws \InvalidArgumentException
     */
    private function validateName($name)
    {
        if (preg_match('/[^a-z_\-0-9]/i', $name)) {
            throw new \InvalidArgumentException(sprintf('Worker name `%s` is invalid.', $name));
        }
    }
    
    /**
     * Configure the current worker
     */
    protected function configure()
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input  = $input;
        $this->output = $output;

        return $this->fire();
    }

    abstract protected function fire();

    /**
     * Runs the worker
     *
     * @param InputInterface
     * @param OutputInterface
     *
     * @return int The exit code
     * @throws \Exception
     */
    public function run(InputInterface $input, OutputInterface $output)
    {
        $statusCode = $this->execute($input, $output);

        return is_numeric($statusCode) ? (int) $statusCode : 0;
    }
}