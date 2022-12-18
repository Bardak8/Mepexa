<?php

namespace Application\Controller\Account\Signup;

use Application\Model\Account\Account;

class Signup
{
    public static function execute() {

        $password = $_POST['password'];
        if ($password != $_POST['password_confirm']) {
            throw new \Exception("Passwords don't match");
        } else {
            $account = Account::GetAccountByName($_POST['username']);
            if ($account != null) {
                throw new \Exception("Account already exists");
            } else {
                Account::CreateAccount($_POST['username'], $_POST['email'], md5($password));
                header('Location: /');
            }
        }
    }
}