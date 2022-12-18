<?php

namespace Application\Controller\Login;


use Application\Model\Account\Account;
use Application\Model\Log\Log;

class Login {

    public static function execute()
    {
        new Log ("Login attempt");
        $password = $_POST['password'];
        $acc = Account::ConnectAccount($_POST['username'], md5($password));
        if ($acc !== null) {
            $_SESSION["username"] = $acc->GetName();
            header('Location: /');
        } else {
            throw new \Exception("Account doesn't exist");
        }
    }
}