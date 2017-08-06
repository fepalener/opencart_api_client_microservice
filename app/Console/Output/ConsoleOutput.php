<?php

namespace App\Console\Output;

class ConsoleOutput implements OutputInterface
{

    /**
     * {@inheritdoc}
     */
    public function write($messages, $newline = false)
    {
        $messages = (array) $messages;

        foreach ($messages as $message) {
            echo $message . ($newline ? "\n" : '');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function writeln($messages)
    {
        $this->write($messages, true);
    }
}