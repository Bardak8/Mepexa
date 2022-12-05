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
    public function Connect(string $pseudo) {
        new Log('Connection attempt of "' . $pseudo . '"');
        
        $this->account = Account::GetAccountByName($pseudo);
        if ($this->account === null) {
            new Log('Connection failed');
            return false;
        }
    }



    public function Disconnet(string $pseudo) {
        new Log('Disconnection attempt of "' . $pseudo . '"');

        $this->account = null;
        $this->connected = false;
    }

    // Getters
    public function GetPseudo() {
        return $this->pseudo;
    }

    public function IsConnected() {
        return isset($_SESSION['username']);
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