<?php
namespace Application\Model\Friend;

require_once('src/pdo/database.php');
require_once('src/model/log.php');
require_once('src/model/account.php');

use Application\Pdo\Database\DatabaseConnection;
use Application\Model\Log\Log;
use Application\Model\Account\Account;

// to remove
class Friend {
    private Account $persona1;
    private Account $persona2;

    public function __construct(Account $persona1, Account $persona2) {
        $this->persona1 = $persona1;
        $this->persona2 = $persona2;
    }

    public function GetP1() : Account {
        return $this->persona1;
    }

    public function GetP2() : Account {
        return $this->persona2;
    }

    public static function RemoveFriend($id1, $id2) {
        new Log('Removing friend for ' . $id1 . ' and ' . $id2);

        $db = new DatabaseConnection();
        $connection = $db->getConnection();
        $query = "DELETE FROM `friends` WHERE (`friends`.`id_account_1` = :id1 AND `friends`.`id_account_2` = :id2) OR (`friends`.`id_account_1` = :id2 AND `friends`.`id_account_2` = :id1)";

        $statement = $connection->prepare($query);

        if ($statement === false) {
            new Log("Error while preparing the query in Friend::RemoveFriend");
            return;
        }

        $statement->execute([
            'id1' => $id1,
            'id2' => $id2
        ]);
    }

    public static function NewFriend($id1, $id2) {
        new Log('Adding friend for ' . $id1 . ' and ' . $id2);

        $db = new DatabaseConnection();
        $connection = $db->getConnection();
        $query = "INSERT INTO `friends` (`id_account_1`, `id_account_2`) VALUES (:id1, :id2)";

        $statement = $connection->prepare($query);

        if ($statement === false) {
            new Log("Error while preparing the query in Friend::NewFriend");
            return;
        }

        $statement->execute([
            'id1' => $id1,
            'id2' => $id2
        ]);
    }
}

class FriendList {
    private Account $account;
    private array $friends = [];

    public function __construct(Account $account) {
        new Log('FriendList created');
        $this->account = $account;

        $db = new DatabaseConnection();
        $query = "SELECT * FROM friends WHERE id_account_1 = :id_account OR id_account_2 = :id_account";
        $statement = $db->getConnection()->prepare($query);

        if ($statement === false) {
            new Log("Error while preparing the query in FriendList::__construct");
            return;
        }

        $statement->execute([
            'id_account' => $this->account->GetId()
        ]);

        $result = $statement->fetchAll();

        foreach ($result as $friend) {
            if ($friend['id_account_1'] == $this->account->GetId()) {
                $this->friends[] = Account::GetAccountById($friend['id_account_2']);
            } else {
                $this->friends[] = Account::GetAccountById($friend['id_account_1']);
            }
        }
    }

    public function GetFriends() : array {
        return $this->friends;
    }

    public function IsFriend(Account $acc) : bool {
        foreach($this->friends as $friend) {
            if ($friend->GetId() == $acc->GetId()) {
                return true;
            }
        }
        return false;
    }
}