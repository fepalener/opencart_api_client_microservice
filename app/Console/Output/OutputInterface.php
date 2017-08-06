<?php

namespace App\Console\Output;

interface OutputInterface
{

    /**
     * @param string|array $messages The message as an array of lines or a single string
     * @param bool         $newline  Whether to add a newline
     */
    public function write($messages, $newline = false);

    /**
     * @param string|array $messages The message as an array of lines or a single string
     */
    public function writeln($messages);
}