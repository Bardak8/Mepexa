<?php
namespace Application\Controller\ProfilePage;

require_once('src/controller/controller.php');
require_once('src/model/account.php');
require_once('src/model/friend.php');
require_once('src/model/pending_request.php');
require_once('src/model/post.php');

use Application\Model\Post\Feed; 
use Application\Controller\Controller\Controller;
use Application\Model\Account\Account;
use Application\Model\Friend\FriendList;
use Application\Model\PendingRequest\PendingRequestList;

class ProfilePage
{
    private Account $account;

    public function __construct(Account $account) {
        $this->account = $account;

        if ($this->account === null) {
            throw new \Exception("Account doesn't exist");
        }
    }

    public function execute(Controller $controller)
    {
        $private = false;   // if user watch his own profile page, variable should be rename
        $has_pending_request = false;   // if user already sent request
        $is_friend = false;             // if user is already friend

        if ($controller->IsConnected()) {
            if ($controller->GetAccount()->GetId() == $this->account->GetId()) {
                $private = true;
            }
        }

        $title = "Мережа - " . $this->account->GetName();

        
        $feed = new Feed();
        $feed->GetsPostsFromUser($this->account->GetId());
        $account = $this->account;
        
        $friends = new FriendList($this->account);
        $sended_requests = new PendingRequestList($this->account, false);
        $receive_requests = new PendingRequestList($this->account, true);

        if (!$private) {
            if ($friends->IsFriend($controller->GetAccount())) {
                $is_friend = true;
            }

            foreach ($sended_requests->GetPendingRequests() as $request) {
                if ($request->GetSender()->GetId() == $controller->GetAccount()->GetId()) {
                    $has_pending_request = true;
                    break;
                }
            }

            foreach ($receive_requests->GetPendingRequests() as $request) {
                if ($request->GetReceiver()->GetId() == $controller->GetAccount()->GetId()) {
                    $has_pending_request = true;
                    break;
                }
            }
        }

        require('template/profile_page.php');
    }
}