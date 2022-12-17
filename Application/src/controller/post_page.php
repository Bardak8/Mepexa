<?php
namespace Application\Controller\Post_Page;

require_once('src/controller/controller.php');
require_once('src/model/post.php');
require_once('src/model/comment.php');


use Application\Controller\Controller\Controller;
use Application\Model\Post\Post;
use Application\Model\Comment\Comment;
use Application\Model\Comment\CommentList;

class Post_Page
{
        public static function execute(Controller $controller, Post $post)
    {

        if ( !$controller->IsConnected()) {
            throw new \Exception("You are not connected");
        }

        $title = "Мережа - Post Page";
        $comment_list = new CommentList($post->GetId());

        require('template/post_page.php');
    }
}
