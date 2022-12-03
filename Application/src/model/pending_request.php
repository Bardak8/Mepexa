<?php
namespace Application\Model\PendingRequest;

require_once('src/pdo/database.php');
require_once('src/model/log.php');
require_once('src/model/account.php');

use Application\Pdo\Database\DatabaseConnection;
use Application\Model\Log\Log;
use Application\Model\Account\Account;

class PendingRequest {
    private Account $sender;
    private Account $receiver;
    private int $statue;    // 0 = pending, 1 = declined

    public function __construct(Account $sender, Account $receiver, int $statue) {
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->statue = $statue;
    }

    public function GetSender() : Account {
        return $this->sender;
    }

    public function GetReceiver() : Account {
        return $this->receiver;
    }

    public function GetStatue() : int {
        return $this->statue;
    }
}

class PendingRequestList {
    private Account $account;
    private array $pending_requests = [];

    public function __construct(Account $account, bool $sender) {
        new Log('PendingRequestList created');
        $this->account = $account;

        $db = new DatabaseConnection();
        $query = "";

        if ($sender) {
            $query = "SELECT * FROM has_pending_request WHERE id_account_1 = :id_account";
        } else {
            $query = "SELECT * FROM has_pending_request WHERE id_account_2 = :id_account AND statue = 0";
        }

        $statement = $db->getConnection()->prepare($query);

        if ($statement === false) {
            new Log("Error while preparing the query in PendingRequestList::__construct");
            return;
        }

        $statement->execute([
            'id_account' => $this->account->GetId()
        ]);

        $result = $statement->fetchAll();

        foreach ($result as $pending_request) {
            if ($pending_request['id_account_1'] == $this->account->GetId()) {
                $this->pending_requests[] = new PendingRequest($this->account, Account::GetAccountById($pending_request['id_account_2']), $pending_request['statue']);
            } else {
                $this->pending_requests[] = new PendingRequest(Account::GetAccountById($pending_request['id_account_1']), $this->account, $pending_request['statue']);
            }
        }
    }

    public function GetPendingRequests() : array {
        return $this->pending_requests;
    }
}