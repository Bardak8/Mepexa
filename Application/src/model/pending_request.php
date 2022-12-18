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
        new Log ("New pending request created");
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->statue = $statue;
    }

    public function GetSender() : Account {
        new Log("PendingRequest::GetSender()");
        return $this->sender;
    }

    public function GetReceiver() : Account {
        new Log("PendingRequest::GetReceiver()");
        return $this->receiver;
    }

    public function GetStatue() : int {
        new Log("PendingRequest::GetStatue()");
        return $this->statue;
    }

    public static function AbortRequest($id1, $id2) {
        //DELETE FROM has_pending_request WHERE `has_pending_request`.`id_account_1` = 3 AND `has_pending_request`.`id_account_2` = 2 » ?
        new Log('Friend request abort for ' . $id1 . ' and ' . $id2);

        $db = new DatabaseConnection();
        $connection = $db->getConnection();
        $query = "DELETE FROM `has_pending_request` WHERE (`has_pending_request`.`id_account_1` = :id1 AND `has_pending_request`.`id_account_2` = :id2) OR (`has_pending_request`.`id_account_1` = :id2 AND `has_pending_request`.`id_account_2` = :id1)";

        $statement = $connection->prepare($query);

        if ($statement === false) {
            new Log("Error while preparing the query in PendingRequestList::AcceptRequest for deleting the pending request");
            return;
        }

        $statement->execute([
            'id1' => $id1,
            'id2' => $id2
        ]);
    }

    public static function AcceptRequest($id1, $id2) {
        new Log('Friend request accepted for ' . $id1 . ' and ' . $id2);

        $db = new DatabaseConnection();
        $connection = $db->getConnection();
        $query = "DELETE FROM `has_pending_request` WHERE (`has_pending_request`.`id_account_1` = :id1 AND `has_pending_request`.`id_account_2` = :id2) OR (`has_pending_request`.`id_account_1` = :id2 AND `has_pending_request`.`id_account_2` = :id1)";

        $statement = $connection->prepare($query);

        if ($statement === false) {
            new Log("Error while preparing the query in PendingRequestList::AcceptRequest for deleting the pending request");
            return;
        }

        $statement->execute([
            'id1' => $id1,
            'id2' => $id2
        ]);

        $query = "INSERT INTO `friends` (`id_account_1`, `id_account_2`) VALUES (:id1, :id2)";

        $statement = $connection->prepare($query);

        if ($statement === false) {
            new Log("Error while preparing the query in PendingRequestList::AcceptRequest for inserting the friend");
            return;
        }

        $statement->execute([
            'id1' => $id1,
            'id2' => $id2
        ]);
    }

    public static function DeclineRequest($id1, $id2) {
        new Log('Friend request refused for ' . $id1 . ' and ' . $id2);

        $db = new DatabaseConnection();
        $connection = $db->getConnection();

        $query = "UPDATE `has_pending_request` SET `statue` = '1' WHERE (`has_pending_request`.`id_account_1` = :id1 AND `has_pending_request`.`id_account_2` = :id2) OR (`has_pending_request`.`id_account_1` = :id2 AND `has_pending_request`.`id_account_2` = :id1)";

        $statement = $connection->prepare($query);

        if ($statement === false) {
            new Log("Error while preparing the query in PendingRequestList::DeclineRequest");
            return;
        }

        $statement->execute([
            'id1' => $id1,
            'id2' => $id2
        ]);

        new Log('Friend request refused for ' . $id1 . ' and ' . $id2);
    }

    public static function NewRequest($id1, $id2) {
        new Log('New friend request for ' . $id1 . ' and ' . $id2);

        $db = new DatabaseConnection();
        $connection = $db->getConnection();

        $query = "INSERT INTO `has_pending_request` (`id_account_1`, `id_account_2`, `statue`) VALUES (:id2, :id1, '0')";

        $statement = $connection->prepare($query);

        if ($statement === false) {
            new Log("Error while preparing the query in PendingRequestList::NewRequest");
            return;
        }

        $statement->execute([
            'id1' => $id1,
            'id2' => $id2
        ]);

        new Log('New friend request for ' . $id1 . ' and ' . $id2);
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
        new Log("PendingRequestList::GetPendingRequests()");
        return $this->pending_requests;
    }
}

//UPDATE `has_pending_request` SET `statue` = '1' WHERE `has_pending_request`.`id_account_1` = 3 AND `has_pending_request`.`id_account_2` = 1 OR `has_pending_request`.`id_account_1` = 1 AND `has_pending_request`.`id_account_2` = 3