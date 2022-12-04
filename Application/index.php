<?php

require_once('src/controller/homepage.php');
require_once('src/controller/profile_page.php');
require_once('src/controller/controller.php');
require_once('src/controller/new_post.php');
require_once('src/controller/search_page.php');
require_once('src/model/log.php');
require_once('src/model/post.php');
require_once('src/model/account.php');

use Application\Controller\Homepage\Homepage;
use Application\Controller\ProfilePage\ProfilePage;
use Application\Controller\Controller\Controller;
use Application\Controller\NewPost\NewPost;
use Application\Controller\SearchPage\Searching;
use Application\Model\Post\Post;
use Application\Model\Log\Log;
use Application\Model\Account\Account;


try {   
    $controller = new Controller();
    // new post page
    if (isset($_GET['new'])) {
        NewPost::execute($controller);
    }
    elseif(isset($_POST['username']) &&  isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password_confirm'])) {
        $password = $_POST['password'];
        if ($password != $_POST['password_confirm']){
            throw new \Exception("Passwords don't match");
        } else {
            $account = Account::GetAccountByName($_POST['username']);
            if ($account != null){
                throw new \Exception("Account already exists");
            } else {
                password_hash($password, PASSWORD_DEFAULT);
                Account::CreateAccount( $_POST['username'], $_POST['email'], $_POST['password']);
                header('Location: /');
            }
        }
    }


    // post upload (to move somewhere else ...)
    elseif (!empty($_POST['post_title']) && isset($_POST['post_content']) ) {
        if ( !$controller->IsConnected()) {
            throw new \Exception("You are not connected");
            return;
        }

        new Log("Account [" . $controller->GetAccount()->GetId() . "] is uploading a new post");

        $file_id = "";
        $errors= array();

        var_dump($_POST);

        if (isset($_FILES['post_media'])) { // this shits sucks, i give up, fuck it
            new Log("Uploading file for account [" . $controller->GetAccount()->GetId() . "] on server...");

            $file = $_FILES['post_media'];
            var_dump($file);
            
            $file_name = $file['name'];
            $file_size = $file['size'];
            $file_tmp = $file['tmp_name'];
            $file_type = $file['type'];

            $tmp = explode('.',$file['name']);
            $file_ext = strtolower(end($tmp));
            
            
            if($file_size > 2097140) {
                $errors[]='File size must be less than 16 MB';
            }

            $file_id = uniqid('u' . $controller->GetAccount()->GetId() . '_') . '.' . $file_ext;
            
            if($file['error'] == 0 && empty($errors)==true) {
                move_uploaded_file($file_tmp, "uploads/" . $file_id);
                new Log("File uploaded for account : " . $controller->GetAccount()->GetId() . " on server successfully : " . $file_id);
            } else {
                foreach ($errors as $error) {
                    new Log("/!\ Error while uploading file : " . $error);
                }

                new Log("/!\ File not uploaded for account : " . $controller->GetAccount()->GetId() . " on server");

                $file_id = "";

                echo "error";
                print_r($errors);
            }
        }

        if (empty($errors)==true) {
            Post::UploadNewPost(
                $controller->GetAccount()->GetId(), 
                $_POST['post_title'], 
                $_POST['post_content'], 
                $file_id
            );
        } else {
            throw new \Exception("Error while uploading post : file too big");
        }

        Homepage::execute($controller);
    }
    // profile page
    elseif (isset($_GET['u'])) {
        $profile_page = new ProfilePage(Account::GetAccountByName($_GET['u']));
        $profile_page->execute($controller);
    }
    // searching page
    elseif (isset($_GET['search_terms'])) {
        Searching::execute($controller);
    }
    // homepage
    else {
        Homepage::execute($controller);
    }


} catch (Exception $e) {
    $errorMessage = $e->getMessage();

    header("Location: index.php?error=" . $errorMessage);
}