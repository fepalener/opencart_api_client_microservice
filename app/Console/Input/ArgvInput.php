<?php

namespace App\Console\Input;

class ArgvInput implements InputInterface
{
    /**
     * @var array
     */
    private $tokens;

    public function __construct(array $argv = null)
    {
        if (null === $argv) {
            $argv = $_SERVER['argv'];
        }

        // strip the script name
        array_shift($argv);

        $this->tokens = $argv;
    }

    /**
     * {@inheritdoc}
     */
    public function getArgument($name, $default = null)
    {
        //@TODO
    }

    public function getFirstArgument()
    {
        if (count($this->tokens)) {
            return $this->tokens[0];
        }

        return null;
    }
}