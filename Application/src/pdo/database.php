<?php

namespace Application\Pdo\Database; 

class DatabaseConnection
{
    public ?\PDO $database = null;

    public function getConnection(): \PDO
    {
        if ($this->database === null) {
            // TODO: Move to config file, this shits is obviously not secure
            $this->database = new \PDO('mysql:host=mepexa;dbname=mapexa2;charset=utf8', 'root', '');
        }

        return $this->database;
    }
}