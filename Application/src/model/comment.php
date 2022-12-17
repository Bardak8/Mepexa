<?php
namespace Application\Model\Comment;

require_once('src/pdo/database.php');
require_once('src/model/log.php');
require_once('src/controller/controller.php');
require_once('src/model/account.php');
require_once('src/model/reaction.php');

use Application\Model\Log\Log;
use Application\Pdo\Database\DatabaseConnection;
use Application\Controller\Controller\Controller;
use Application\Model\Account\Account;
use Application\Model\Reaction\Reaction;

class Comment {
    public int $id;
    public int $id_post;
    public int $id_author;
    public ?int $id_comment_answer;
    public string $content;
    public Reaction $reaction;

    public ?Account $author;

    public Array $answers;

    public function __construct(int $id, int $id_post, int $id_author, ?int $id_comment_answer, string $content, ?Account $author, Reaction $reaction) {
        $this->id = $id;
        $this->id_post = $id_post; 
        $this->id_author = $id_author;
        $this->id_comment_answer = $id_comment_answer;
        $this->content = $content;
        $this->author = $author; 
        $this->answers = Array();
        $this->reaction = $reaction;
    }

    public static function GetCommentById(int $id_comment) : Comment {
        $query = "SELECT * FROM comments WHERE id_comment = :id_comment";
        $statement = (new DatabaseConnection())->getConnection()->prepare($query);

        if ($statement === false) {
            throw new \Exception("Error while preparing the query");
        }

        $statement->execute([
            'id_comment' => $id_comment
        ]);

        $result = $statement->fetch();

        $author = Account::GetAccountById($result['id_account']);
        

        if ($result['id_comment_Comments'] != NULL) {

        }

        if ($result) {
            $reaction = Reaction::GetCommentReaction($result['id_post'], $result['id_comment']);
            return new Comment($result['id_comment'], $result['id_post'], $result['id_account'], $result['id_comment_Comments'], 
                               $result['content'], $author, $reaction);
        } else {
            throw new \Exception("Error while fetching the result");
        }
    }

    public static function CreateComment($id_post, $comment, $id_account) {
        new Log("Comment::CreateComment() of account [" . $id_account . "]");
        $db = new DatabaseConnection();
        $connection = $db->getConnection();

        $statement = $connection->prepare("INSERT INTO `comments` (`id_comment`, `content`, `id_account`, `id_post`, `id_comment_Comments`) VALUES (NULL, :content, :id_account, :id_post, NULL)");
        $statement->bindParam(':content', $comment);
        $statement->bindParam(':id_account', $id_account);
        $statement->bindParam(':id_post', $id_post);

        $statement->execute();

        header('Location: /?post='.$id_post);
    }

    public static function DeleteComment($id_comment) {
        new Log("Comment::DeleteComment() of comment [" . $id_comment . "]");

        Reaction::DeleteCommentsReaction($id_comment);

        $query = "DELETE FROM comments WHERE id_comment = :id_comment";
        $statement = (new DatabaseConnection())->getConnection()->prepare($query);

        $result = $statement->execute(
            ['id_comment' => $id_comment]
        );
        if (!$result) {
            throw new \Exception("Error while deleting post");
        }
    }

    public static function DeletePostComments(int $id_post) {
        new Log("Comment::DeletePostComments() of post [" . $id_post . "]");

        $query = "DELETE FROM comments WHERE id_post = :id_post";
        $statement = (new DatabaseConnection())->getConnection()->prepare($query);

        $result = $statement->execute(
            ['id_post' => $id_post]
        );
        if (!$result) {
            throw new \Exception("Error while deleting post");
        }
    }

    public function GetId() {
        return $this->id;
    }

    public function GetIdPost() {
        return $this->id_post;
    }

}


class CommentList {
    private int $id_post;
    public Array $comments;

    public function __construct(int $id_post) {
        $this->id_post = $id_post;
        $this->comments = Array();

        $query = "SELECT * FROM comments WHERE id_post = :id_post ORDER BY id_comment DESC";
        $statement = (new DatabaseConnection())->getConnection()->prepare($query);

        if ($statement === false) {
            throw new \Exception("Error while preparing the query");
        }

        $statement->execute(['id_post' => $id_post]);

        while ($row = $statement->fetch()) {
            $author = Account::GetAccountById($row['id_account']);
            $reaction = Reaction::GetCommentReaction($row['id_post'], $row['id_comment']);
            $new_comment = new Comment($row['id_comment'], $row['id_post'], $row['id_account'], $row['id_comment_Comments'], 
                                   $row['content'], $author, $reaction);
            
            $this->comments[] = $new_comment;
        }
    }
}