<?php
namespace Application\Model\Account;

require_once('src/pdo/database.php');
require_once('src/model/log.php');
require_once('src/controller/controller.php');

use Application\Model\Log\Log;
use Application\Pdo\Database\DatabaseConnection;
use Application\Controller\Controller\Controller;

class Account {
    // Variables
    private int $id;
    private string $name;
    private string $email;
    private string $encrypted_password;

    
    // Constructor
    public function __construct(int $id, string $name, string $email, string $encrypted_password) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->encrypted_password = $encrypted_password;
    }

    
    // Main methods
    public static function GetAccountByName(string $pseudo) : ?Account {
        $query = "SELECT * FROM accounts WHERE name = :pseudo";
        $statement = (new DatabaseConnection())->getConnection()->prepare($query);

        if ($statement === false) {
            new Log("Error while preparing the query in Account::GetAccountByName");
            return null;
        }

        $statement->execute([
                'pseudo' => $pseudo
            ]);

        $result = $statement->fetch();

        if ($result) {
            return new Account($result['id_account'], $result['name'], $result['email'], $result['encrypted_password']);
        } else {
            new Log("No account found with pseudo: " . $pseudo . " in Account::GetAccountByName");
            return null;
        }
    }

    public static function GetAccountBYEmail(string $email) : ?Account {
        $query = "SELECT * FROM accounts WHERE email = :email";
        $statement = (new DatabaseConnection())->getConnection()->prepare($query);

        if ($statement === false) {
            new Log("Error while preparing the query in Account::GetAccountBYEmail");
            return null;
        }

        $statement->execute([
                'email' => $email
            ]);

        $result = $statement->fetch();

        if ($result) {
            return new Account($result['id_account'], $result['name'], $result['email'], $result['encrypted_password']);
        } else {
            new Log("No account found with email: " . $email . " in Account::GetAccountBYEmail");
            return null;
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

    public static function CreateAccount(string $name, string $email, string $encrypted_password )
    {
        $query = "INSERT INTO accounts (id_account, name, email, encrypted_password) VALUES (NULL, :name, :email, :encrypted_password)";
        $statement = (new DatabaseConnection())->getConnection()->prepare($query);

        if ($statement === false) {
            throw new \Exception("Error while preparing the query");
        }

        $result = $statement->execute([
            'name' => $name,
            'email' => $email,
            'encrypted_password' => $encrypted_password
        ]);

        if (!$result) {
            new Log("Error while fetching the result in Account::CreateAccount");
            throw new \Exception("Error while fetching the result");
        }
    }

    public function CompareEncryptedPassword(string $psw) {
        return ($this->encrypted_password == $psw);
    }


    public static function ConnectAccount(string $name, string $psw ) : ?Account {
        $account = Account::GetAccountByName($name);
        if ($account) {
            if ($account->CompareEncryptedPassword($psw)) {
                return $account;
            } else {
                new Log("Wrong password for account: " . $name . " in Account::ConnectAccount");
                throw new \Exception("Wrong password for account: " . $name . " in Account::ConnectAccount");
                return null;
            }

        } else {
            new Log("No account found with pseudo: " . $name . " in Account::ConnectAccount");
            $account = Account::GetAccountByEmail($name);
            if ($account) {
                if ($account->CompareEncryptedPassword($psw)) {
                    return $account;
                } else {
                    new Log("Wrong password for account: " . $name . " in Account::ConnectAccount");
                    return null;
                }
            }
        }
        throw new \Exception("Wrong password for account: " . $name . " in Account::ConnectAccount");
        return null;

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