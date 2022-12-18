<?php
namespace Application\Controller\Post_Page;

require_once('src/controller/controller.php');
require_once('src/model/post.php');
require_once('src/model/comment.php');
require_once('src/model/reaction.php');

use Application\Controller\Controller\Controller;
use Application\Model\Post\Post;
use Application\Model\Reaction\Reaction;
use Application\Model\Comment\Comment;
use Application\Model\Comment\CommentList;

class Post_Page
{
        public static function execute(Controller $controller) {

        $post = Post::GetPostById($_GET['post']);
        if ($post == null) {
            throw new \Exception("Post not found");
        }

        if ( !$controller->IsConnected()) {
            throw new \Exception("You are not connected");
        }

        $title = "Мережа - Post Page";
        $comment_list = new CommentList($post->GetId()); // to move to post model

        //Reaction::ReactToPost($controller->GetAccount()->GetId(), $post->GetId(), NULL, 1);

        $post_reactions = Reaction::GetPostsReaction($post->GetId());


        require('template/post_page.php');
    }
}
