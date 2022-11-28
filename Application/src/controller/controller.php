<?php

namespace Application\Controller\Controller;

require_once('src/model/account.php');

use Application\Model\Account\Account; 

class Controller
{
    private bool $connected = false;
    private Account $account;


    // Main functions
    public function Connect(string $pseudo, string $encrypted_password) {
        $account = Account::GetAccountByName($pseudo);

        if ($account->CompareEncryptedPassword($encrypted_password)) {
            $this->connected = true;
            $this->account = $account;
        } else {
            throw new \Exception("Wrong password");
        }
    }

    // Getters
    public function GetPseudo() {
        return $this->pseudo;
    }

    public function IsConnected() {
        return $this->connected;
    }

    public function GetAccount() {
        return $this->account;
    }

    // Setters
    public function SetConnected(bool $connected) {
        $this->connected = $connected;
    }

    public function SetPseudo(string $pseudo) {
        $this->pseudo = $pseudo;
    }
}