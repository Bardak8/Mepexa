<?php
namespace Application\Model\Post;

require_once('src/pdo/database.php');
require_once('src/model/account.php');
require_once('src/model/friend.php');
require_once('src/model/comment.php');
require_once('src/model/reaction.php');

use Application\Model\Friend\FriendList;
use Application\Pdo\Database\DatabaseConnection;
use Application\Model\Account\Account;
use Application\Model\Log\Log;
use Application\Model\Friend;
use Application\Model\Comment\Comment;

use Application\Model\Reaction\Reaction;

class Post
{
    // Variables
    private ?int $id;
    private int $id_account;
    private string $author;
    private string $title;
    private string $content;
    private ?string $media_path;
    private string $date;
    public Reaction $reaction;


    // Constructor
    public function __construct(?int $id, int $id_account, string $author, string $title, string $content, $media_path, ?string $date)
    {
        new Log("Post created");
        $this->id = $id;
        $this->id_account = $id_account;
        $this->author = $author;
        $this->title = $title;
        $this->content = $content;
        $this->media_path = $media_path;
        $this->date = $date;

        $this->reaction =  Reaction::GetPostsReaction($id);
    }

    public static function UploadNewPost(int $id_account, string $title, string $content, string $media_path)
    {
        new Log("Post::UploadNewPost() of account [" . $id_account . $title . $content . $media_path . "]");
        // INSERT INTO `posts` (`id_post`, `title`, `content`, `media_path`, `id_account`, `post_date`) 
        // VALUES (NULL, 'ceci est le titre', 'lorem ipsum ', NULL, '', NULL)
        $db = new DatabaseConnection();
        $connection = $db->getConnection();

        $statement = $connection->prepare("INSERT INTO `posts` (`id_post`, `title`, `content`, `media_path`, `id_account`, `post_date`) VALUES (NULL, :title, :content, :media_path, :id_account, :post_date)");
        $statement->bindParam(':title', $title);
        $statement->bindParam(':content', $content);
        if ($media_path === '') {
            $statement->bindValue(':media_path', null, \PDO::PARAM_NULL);
        } else {
            $statement->bindParam(':media_path', $media_path);
        }
        $statement->bindParam(':id_account', $id_account);
        $statement->bindValue(':post_date', date('Y-m-d H:i:s'));

        $statement->execute();
    }


    // Getters
    public function GetId()
    {
        new Log("Post::GetId()");
        return $this->id;
    }

    public function GetIdAuthor()
    {
        new Log("Post::GetIdAuthor()");
        return $this->id_account;
    }

    public function GetAuthor()
    {
        new Log("Post::GetAuthor()");
        return $this->author;
    }

    public function GetTitle()
    {
        new Log("Post::GetTitle()");
        return $this->title;
    }

    public function GetContent()
    {
        new Log("Post::GetContent()");
        return $this->content;
    }

    public function GetMediaPath()
    {
        new Log("Post::GetMediaPath()");
        return $this->media_path;
    }

    public function GetDate()
    {
        new Log("Post::GetDate()");
        return $this->date;
    }


    public static function GetPostById(int $id_post): ?Post
    {
        new Log("Post::GetPostById() of post [" . $id_post . "]");

        $query = "SELECT * FROM posts WHERE id_post = :id_post";
        $statement = (new DatabaseConnection())->getConnection()->prepare($query);

        $statement->execute([
            'id_post' => $id_post,
        ]);
        $post = $statement->fetch();
        if ($post) {
            $author = Account::GetAccountById($post['id_account'])->GetName();
            return new Post ( $post['id_post'],$post['id_account'], $author , $post['title'], $post['content'], $post['media_path'], $post['post_date']);
        } else {
            throw new \Exception("Error while fetching the result");
            return null;
        }
    }

    public static function DeletePost(int $id_post)
    {
        new Log("Post::DeletePost() of post [" . $id_post . "]");
        Reaction::DeletePostReaction($id_post);
        Comment::DeletePostComments($id_post);

        $query = "DELETE FROM posts WHERE id_post = :id_post";
        $statement = (new DatabaseConnection())->getConnection()->prepare($query);

        $result = $statement->execute(
            ['id_post' => $id_post]
        );
        if (!$result){
            throw new \Exception("Error while deleting post");
        }
    }
}



class Feed {
    private \PDO $connection;
    private array $posts;

    public function __construct() {
        new Log("Feed created");
        $this->connection = (new DatabaseConnection())->getConnection();
        $this->posts = [];
    }



    public function GenerateFeed($account, $current_page)
    {
        new Log("Feed::GenerateFeed() of account [" . $account . $current_page . "]");

        $friends = new FriendList($account);

        $query = "SELECT * FROM posts WHERE id_account = " . $account->GetId() ;


        foreach ($friends -> GetFriends() as $friend) {

            $query .= " OR id_account = " . $friend -> GetId();
        }

        $query .= " ORDER BY id_post DESC ";

        if ($current_page > 1) {
            $query .= " LIMIT " . ($current_page - 1) * 10 . ", 10";
        } else {
            $query .= " LIMIT 0, 10";
        }



        $statement = $this->connection->prepare($query);

        if ($statement === false) {
            throw new \Exception("Error while fetching posts");
            return;
        }

        $statement->execute();

        while (($row = $statement->fetch())) {

            $author = Account::GetAccountById($row['id_account'])->GetName();

            $this->posts[] = new Post($row['id_post'], $row['id_account'], $author, $row['title'], $row['content'], $row['media_path'], $row['post_date']);
        }

    }

    public static function GetPageNumber(): int
    {
        new Log("Feed::GetPageNumber() of feed");
        $query = "SELECT id_post FROM posts";
        $statement = (new DatabaseConnection())->getConnection()->prepare($query);
        $statement->execute();
        $count = $statement->rowCount();
        return $count;
    }


    public function GetsPostsFromUser(int $id_account)
    {
        new Log("Feed::GetPostsFromUser() of account [" . $id_account . "]");
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
        new Log("Feed::GetPosts()");
        return $this->posts;
    }


}