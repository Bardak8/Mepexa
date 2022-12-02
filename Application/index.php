<?php

require_once('src/controller/homepage.php');
require_once('src/controller/controller.php');

use Application\Controller\Homepage\Homepage;
use Application\Controller\Controller\Controller;


try {   
    $controller = new Controller();
    $controller->Connect('Ben', '123456789');

    Homepage::execute($controller);

} catch (Exception $e) {
    $errorMessage = $e->getMessage();

    require('template/error.php');
}