<?php
namespace Application\Controller\NewPost;

require_once('src/controller/controller.php');

use Application\Controller\Controller\Controller;

class NewPost
{
    public static function execute(Controller $controller)
    {
        if ( !$controller->IsConnected()) {
            throw new \Exception("You are not connected");
            return;
        }

        $title = "Мережа - New Post";

        require('template/new_post.php');
    }
}