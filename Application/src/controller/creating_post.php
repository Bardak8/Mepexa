<?php


namespace Application\Controller\Creating_Post;


use Application\Controller\Controller\Controller;
use Application\Model\Log\Log;
use Application\Model\Post\Post;

class Creating_Post {

        public static function execute(Controller $controller)
        {
            new Log("Creation post created");
            if (!$controller->IsConnected()) {
                throw new \Exception("You are not connected");
                return;
            }

            new Log("Account [" . $controller->GetAccount()->GetId() . "] is uploading a new post");

            $file_id = "";
            $errors = array();

            if (isset($_FILES['post_media'])) {
                new Log("Uploading file for account [" . $controller->GetAccount()->GetId() . "] on server...");

                $file = $_FILES['post_media'];

                $file_name = $file['name'];
                $file_size = $file['size'];
                $file_tmp = $file['tmp_name'];
                $file_type = $file['type'];

                $tmp = explode('.', $file['name']);
                $file_ext = strtolower(end($tmp));


                if ($file_size > 2097140) {
                    $errors[] = 'File size must be less than 2MB';
                }

                $file_id = uniqid('u' . $controller->GetAccount()->GetId() . '_') . '.' . $file_ext;

                if ($file['error'] == 0 && empty($errors)) {
                    move_uploaded_file($file_tmp, "uploads/" . $file_id);
                    new Log("File uploaded for account : " . $controller->GetAccount()->GetId() . " on server successfully : " . $file_id);
                } else {
                    foreach ($errors as $error) {
                        new Log("/!\ Error while uploading file : " . $error);
                    }

                    new Log("/!\ File not uploaded for account : " . $controller->GetAccount()->GetId() . " on server");

                    $file_id = "";

                }
            }

            if (empty($errors) == true) {
                Post::UploadNewPost(
                    $controller->GetAccount()->GetId(),
                    $_POST['post_title'],
                    $_POST['post_content'],
                    $file_id
                );
            } else {
                throw new \Exception("Error while uploading post : file too big");
            }
        }
}