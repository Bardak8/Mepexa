<?php

require_once('src/controller/homepage.php');
require_once('src/controller/controller.php');
require_once('src/controller/new_post.php');

use Application\Controller\Homepage\Homepage;
use Application\Controller\Controller\Controller;
use Application\Controller\NewPost\NewPost;


try {   
    $controller = new Controller();
    $controller->Connect('Ben', '123456789');

    if (isset($_GET['new'])) {
        NewPost::execute($controller);
    } 
    elseif (isset($_POST['post_title']) && isset($_POST['post_content']) ) {
        NewPost::UploadPost(
            $controller, $_POST['post_title'], 
            $_POST['post_content'], 
            $_POST['post_media']
        );
        var_dump($_POST);
        Homepage::execute($controller);
    } 
    else {
        Homepage::execute($controller);
    }

} catch (Exception $e) {
    $errorMessage = $e->getMessage();

    require('template/error.php');
}