<?php

namespace Application\Model\Log; 

class Log {
    private string $message;
    private string $date;

    public function __construct(string $message) {
        new Log("New log created");
        $this->message = $message;
        $this->date = date('Y-m-d H:i:s');
    }

    public function getMessage(): string {
        new Log("Log::getMessage()");
        return $this->message;
    }

    public function getDate(): string {
        new Log("Log::getDate()");
        return $this->date;
    }

    public function __toString(): string {
        new Log("Log::__toString()");
        return $this->date . ' - ' . $this->message;
    }

    public function __destruct() {
        new Log("Log::__destruct()");
        $file = fopen('log.txt', 'a+');
        fwrite($file, $this->__toString() . PHP_EOL);
        fclose($file);
    }
}