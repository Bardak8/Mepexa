<?php
namespace Application\Controller\Homepage;

require_once('src/controller/controller.php');
require_once('src/model/post.php');

use Application\Model\Post\Feed; 
use Application\Controller\Controller\Controller;
use Application\Model\Account\Account;
use Application\Pdo\Database\DatabaseConnection;

class Homepage
{
    public static function execute(Controller $controller)
    {
        $title = "Мережа";

        $feed = new Feed();

        $current_page = 1;
        if (isset($_GET['page'])) {
            $current_page = $_GET['page'];
        }

        $nbPosts = Feed::GetPageNumber();
        $nbPages = ceil($nbPosts / 10) ;

        
        if ($controller->IsConnected()) {
            $feed->GenerateFeed($controller->GetAccount(), $current_page);
        }
        var_dump($current_page);



        require('template/feed.php');


    }
}