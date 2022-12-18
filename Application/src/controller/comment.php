<?php


namespace Application\Controller\Comment;


use Application\Controller\Controller\Controller;
use Application\Model\Comment\Comment;
use Application\Model\Log\Log;


class Comments
{

    public static function execute(Controller $controller)
    {
        new Log("Comments::execute()");
        Comment::CreateComment($_GET['post'], $_POST['comment_content'], $controller->GetAccount()->GetId());
    }

}