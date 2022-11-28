<?php
namespace Application\Model\Post;

require_once('src/pdo/database.php');
require_once('src/model/account.php');

use Application\Pdo\Database\DatabaseConnection;
use Application\Model\Account\Account;

class Post {
    // Variables
    private int $id;
    private int $id_account;
    private string $author;
    private string $title;
    private string $content;
    private $media_path;
    private string $date;


    // Constructor
    public function __construct(int $id, int $id_account, string $author, string $title, string $content, $media_path, string $date) {
        $this->id = $id;
        $this->id_account = $id_account;
        $this->author = $author;
        $this->title = $title;
        $this->content = $content;
        $this->media_path = $media_path;
        $this->date = $date;
    }


    // Getters
    public function GetId() {
        return $this->id;
    }

    public function GetIdAuthor() {
        return $this->id_account;
    }

    public function GetAuthor() {
        return $this->author;
    }

    public function GetTitle() {
        return $this->title;
    }

    public function GetContent() {
        return $this->content;
    }

    public function GetMediaPath() {
        return $this->media_path;
    }

    public function GetDate() {
        return $this->date;
    }
}


class Feed {
    private \PDO $connection;
    private array $posts;

    public function __construct() {
        $this->connection = (new DatabaseConnection())->getConnection();
        $this->posts = [];
    }

    public function GenerateFeed(int $id_account)
    {
        $query = "SELECT * FROM posts WHERE id_account = :id_account ORDER BY id_post DESC";
        $statement = $this->connection->prepare($query);

        if ($statement === false) {
            throw new \Exception("Error while fetching posts");
            return;
        }

        $statement->execute(['id_account' => $id_account]);

        while (($row = $statement->fetch())) {
            $author = Account::GetAccountById($row['id_account'])->GetName();

            $this->posts[] = new Post($row['id_post'], $row['id_account'], $author, $row['title'], $row['content'], $row['media_path'], $row['post_date']);
        }
    }

    public function GetPosts() : array {
        return $this->posts;
    }
}