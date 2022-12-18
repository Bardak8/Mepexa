<?php


namespace Application\Controller\Close_Post;



use Application\Model\Post\Post;

class Close_Post {

   public static function execute()
    {
        $post = Post::GetPostById($_GET['close_post']);
        if ($post == null) {
            throw new \Exception("Post not found");
        }
        $post_id = $post->GetId();
        Post::DeletePost($post_id);
        header('Location: /');
    }
}