<?php

namespace Application\Pdo\Database; 

class DatabaseConnection
{
    public ?\PDO $database = null;

    public function getConnection(): \PDO
    {
        $file = 'credentials.json';
        $data = file_get_contents($file);
        $obj = json_decode($data);

        if ($this->database === null) {
            // TODO: Move to config file, this shits is obviously not secure
            $this->database = new \PDO('mysql:host=' . $obj->host . ';dbname=' . $obj->dbname . ';charset=utf8', $obj->username, $obj->password);
        }

        return $this->database;
    }
}