<?php
namespace Application\Controller\NewPost;

require_once('src/controller/controller.php');
require_once('src/model/post.php');

use Application\Model\Post\Post; 
use Application\Model\Post\Feed; 
use Application\Controller\Controller\Controller;
use Application\Model\Account\Account;

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

    public static function UploadPost(Controller $controller, string $title, string $content, $media)
    {
        if ( !$controller->IsConnected()) {
            throw new \Exception("You are not connected");
            return;
        }

        /*

        1) get all this shits :
            $id_account;    from $controller
            $title;         from $_POST['post_title']
            $content;       from $_POST['post_content']
            $media_path;    from $_POST['post_media']
            $date;          from date('Y-m-d H:i:s')
        
        2) upload media on server if there is one 
            (if $media_path != null)
                $media_path = 'media/' . $media['name'];
                move_uploaded_file($media['tmp_name'], $media_path);

        3) create post model
            new Post(...);

        4) upload post on database 
            $post->UploadPost();

        */
    }
}