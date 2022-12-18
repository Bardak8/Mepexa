<?php
namespace Application\Controller\SearchPage;

require_once('src/controller/controller.php');
require_once('src/pdo/database.php');
require_once('src/model/account.php');
require_once('src/model/friend.php');
require_once('src/model/pending_request.php');

use Application\Controller\Controller\Controller;
use Application\Pdo\Database\DatabaseConnection;
use Application\Model\Log\Log;

class Searching
{
    public static function execute(Controller $controller)
    {
        new Log ("Searching page created");
        $search_terms = $_GET['search_terms'];
        $result = Array();
        $title = "Searching page";


        $db = new DatabaseConnection();
        $connection = $db->getConnection();

        $results = $connection->query('SELECT * FROM accounts');
        if (isset($_GET['search_terms']) and !empty($_GET['search_terms'])) {
            $q = htmlspecialchars($_GET['search_terms']);
            $results = $connection->query('SELECT name FROM accounts WHERE name LIKE "%' . $q . '%" ');
            if ($results->rowCount() == 0) {
                $result = null;
            }
        } elseif (empty($_GET['search_terms'])) {
            $result = null;
        }


        require('template/searching_page.php');
    }
}
