<?php

namespace App\Log;

class Logger
{
    private $handle;

    /**
     * Log file path
     * 
     * @var string
     */
    private $file;

    public function __construct($file)
    {
        $this->file   = $file;
        $this->handle = fopen($this->file, 'a');

        $this->rotate();
    }

    /**
     * @param string $message
     */
    public function write($message)
    {
        fwrite($this->handle, date('Y-m-d G:i:s') . ' - ' . print_r($message, true) . "\n");
    }

    /**
     * Rotate log file
     *
     * @return boolean
     */
    public function rotate(): bool
    {
        if (!is_file($this->file)) {
            return false;
        }

        if (date('Y-m-d', filemtime($this->file)) != date('Y-m-d')) {
            $info = pathinfo($this->file);

            return rename($this->file, $info['dirname'] . '/' . $info['filename'] . '_' . date('Y-m-d') . '.' . $info['extension']);
        }

        return false;
    }

    public function __destruct()
    {
        fclose($this->handle);
    }
}