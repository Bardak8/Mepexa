<?php

namespace Application\Controller\Controller;

require_once('src/model/account.php');
require_once('src/model/log.php');

use Application\Model\Log\Log;
use Application\Model\Account\Account; 

class Controller
{
    private bool $connected = false;
    private ?Account $account = null;

    public function __construct()
    {
        new Log('Controller created');
    }


    // Main functions
    public function Connect(string $pseudo, string $encrypted_password) {
        new Log('Connection attempt of "' . $pseudo . '"');
        
        $account = Account::GetAccountByName($pseudo);
        if ($account === null) { return; }

        if ($account->CompareEncryptedPassword($encrypted_password)) {
            $this->connected = true;
            $this->account = $account;
            new Log('Connection of "' . $pseudo . '" successful');
        } else {
            new Log('Connection of "' . $pseudo . '" failed : wrong password');
            throw new \Exception("Wrong password");
        }
    }

    public function Disconnect() {
        if ($this->connected) {
            new Log('Disconnection of "' . $this->account->getName() . '"');
            $this->connected = false;
            $this->account = null;
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