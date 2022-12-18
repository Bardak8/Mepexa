<?php

namespace Application\Controller\Reaction;



use Application\Controller\Controller\Controller;
use Application\Model\Reaction\Reaction;

class Reactions
{

    public static function execute(Controller $controller)
    {
        if (isset($_POST['id_comm_reaction'])) {
            Reaction::ReactToPost(
                $controller->GetAccount()->GetId(),
                $_POST['id_post_reaction'],
                $_POST['id_comm_reaction'],
                $_POST['reaction_type']
            );
        } else {
            Reaction::ReactToPost(
                $controller->GetAccount()->GetId(),
                $_POST['id_post_reaction'],
                NULL,
                $_POST['reaction_type']
            );
        }
    }
}