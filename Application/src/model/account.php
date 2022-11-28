<?php
namespace Application\Model\Account;

require_once('src/pdo/database.php');

use Application\Pdo\Database\DatabaseConnection;

class Account {
    // Variables
    private int $id;
    private string $name;
    private string $email;
    private string $encrypted_passord;

    
    // Constructor
    public function __construct(int $id, string $name, string $email, string $encrypted_passord) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->encrypted_passord = $encrypted_passord;
    }

    
    // Main methods
    public static function GetAccountByName(string $pseudo) : Account {
        $query = "SELECT * FROM accounts WHERE name = :pseudo";
        $statement = (new DatabaseConnection())->getConnection()->prepare($query);

        if ($statement === false) {
            throw new \Exception("Error while preparing the query");
        }

        $statement->execute([
                'pseudo' => $pseudo
            ]);

        $result = $statement->fetch();

        if ($result) {
            return new Account($result['id_account'], $result['name'], $result['email'], $result['encrypted_password']);
        } else {
            throw new \Exception("Error while fetching the result");
        }
    }

    public static function GetAccountById(int $id_account) : Account {
        $query = "SELECT * FROM accounts WHERE id_account = :id_account";
        $statement = (new DatabaseConnection())->getConnection()->prepare($query);

        if ($statement === false) {
            throw new \Exception("Error while preparing the query");
        }

        $statement->execute([
            'id_account' => $id_account
        ]);

        $result = $statement->fetch();

        if ($result) {
            return new Account($result['id_account'], $result['name'], $result['email'], $result['encrypted_password']);
        } else {
            throw new \Exception("Error while fetching the result");
        }
    }

    public function CompareEncryptedPassword(string $psw) {
        return ($this->encrypted_passord == $psw);
    }


    // Getters
    public function GetId() {
        return $this->id;
    }

    public function GetName() {
        return $this->name;
    }

    public function GetEmail() {
        return $this->email;
    }
}