<?php

namespace Application\Controller\Close_Comment;

use Application\Model\Comment\Comment;


Class Close_Comment {

    public static function execute()
    {
        $comment = Comment::GetCommentById($_GET['close_comment']);
        if ($comment == null) {
            throw new \Exception("Post not found");
        }
        $comment_id = $comment->GetId();
        Comment::DeleteComment($comment_id);
        header('Location: /?post=' . $comment->GetIdPost());
    }
}