<?php
namespace Application\Controller\Post_Page;

require_once('src/controller/controller.php');
require_once('src/model/post.php');

use Application\Controller\Controller\Controller;
use Application\Model\Post\Post;


class Post_Page
{
        public static function execute(Controller $controller, Post $post)
    {

        if ( !$controller->IsConnected()) {
            throw new \Exception("You are not connected");
        }

        $title = "Мережа - Post Page";

        require('template/post_page.php');
    }
}
