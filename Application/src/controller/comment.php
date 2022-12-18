<?php


namespace Application\Controller\Comment;


use Application\Controller\Controller\Controller;
use Application\Model\Comment\Comment;


class Comments
{

    public static function execute(Controller $controller)
    {
        Comment::CreateComment($_GET['post'], $_POST['comment_content'], $controller->GetAccount()->GetId());
    }

}