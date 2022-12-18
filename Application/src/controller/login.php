<?php

namespace Application\Controller\Login;


use Application\Model\Account\Account;

class Login {

    public static function execute()
    {
        $password = $_POST['password'];
        //$acc = Account::ConnectAccount($_POST['username'], md5($password));
        $acc = Account::ConnectAccount($_POST['username'], $password);
        if ($acc !== null) {
            $_SESSION["username"] = $acc->GetName();
            header('Location: /');
        } else {
            throw new \Exception("Account doesn't exist");
        }
    }
}