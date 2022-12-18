<?php


namespace Application\Controller\Friend;




use Application\Controller\Controller\Controller;
use Application\Model\Friend\Friend;
use Application\Model\PendingRequest\PendingRequest;

class Friend_Request
{
    public static function execute (Controller $controller){

        if (isset($_POST['friend_request'])) {
            echo $controller->GetAccount()->GetId();
            if ($_POST['friend_request'] == 'accept') {
                PendingRequest::AcceptRequest($_POST['request_id'], $controller->GetAccount()->GetId());
            } elseif ($_POST['friend_request'] == 'refuse') {
                PendingRequest::DeclineRequest($_POST['request_id'], $controller->GetAccount()->GetId());
            } elseif ($_POST['friend_request'] == 'delete') {
                Friend::RemoveFriend($_POST['request_id'], $controller->GetAccount()->GetId());
            } elseif ($_POST['friend_request'] == 'new') {
                PendingRequest::NewRequest($_POST['request_id'], $controller->GetAccount()->GetId());
            } elseif ($_POST['friend_request'] == 'abort') {
                PendingRequest::AbortRequest($_POST['request_id'], $controller->GetAccount()->GetId());
            } else {
                throw new \Exception("Invalid friend request");
            }
        }
    }

}