<?php
namespace Application\Model\Reaction;

require_once('src/pdo/database.php');

use Application\Pdo\Database\DatabaseConnection;
use Application\Model\Log\Log;

class Reaction
{
    public int $laugh;       // 1
    public int $love;        // 2
    public int $sad;         // 3
    public int $thumb_down;  // 4
    public int $thumb_up;    // 5

    public function __construct(int $laugh, int $love, int $sad, int $thumb_down, int $thumb_up)
    {
        new Log("Reaction created");
        $this->laugh = $laugh;
        $this->love = $love;
        $this->sad = $sad;
        $this->thumb_down = $thumb_down;
        $this->thumb_up = $thumb_up;
    }

    public static function GetPostsReaction(int $id_post) : Reaction {
        new Log("Reaction::GetPostsReaction() of post [" . $id_post . "]");
        $laugh = 0;
        $love = 0;
        $sad = 0;
        $thumb_down = 0;
        $thumb_up = 0;
        
        $query = "SELECT * FROM reactions WHERE id_post = :id_post AND id_comment IS NULL";
        $statement = (new DatabaseConnection())->getConnection()->prepare($query);
        $statement->execute([
            'id_post' => $id_post,
        ]);

        while ($row = $statement->fetch()) {
            $laugh += $row['laugh'];
            $love += $row['love'];
            $sad += $row['sad'];
            $thumb_down += $row['thumb_down'];
            $thumb_up += $row['thumb_up'];
        }

        return new Reaction($laugh, $love, $sad, $thumb_down, $thumb_up);
    }

    public static function GetCommentReaction(int $id_post, int $id_comment) : Reaction {
        new Log("Reaction::GetCommentReaction() of post [" . $id_post . $id_comment . "]");
        $laugh = 0;
        $love = 0;
        $sad = 0;
        $thumb_down = 0;
        $thumb_up = 0;
        
        $query = "SELECT * FROM reactions WHERE id_post = :id_post AND id_comment = :id_comment";
        $statement = (new DatabaseConnection())->getConnection()->prepare($query);
        $statement->execute([
            'id_post' => $id_post,
            'id_comment' => $id_comment
        ]);

        while ($row = $statement->fetch()) {
            $laugh += $row['laugh'];
            $love += $row['love'];
            $sad += $row['sad'];
            $thumb_down += $row['thumb_down'];
            $thumb_up += $row['thumb_up'];
        }

        return new Reaction($laugh, $love, $sad, $thumb_down, $thumb_up);
    }

    // $reaction
    // 1😂
    // 3😢
    // 2❤
    // 4👎
    // 5👍

    public static function ReactToPost(int $id_account, int $id_post, ?int $id_comment, int $reaction) {
        new Log("Reaction::ReactToPost() of  [" . $id_account . $id_post . $id_comment . $reaction . "]");
        $query = "SELECT * FROM reactions WHERE id_post = :id_post AND id_account = :id_account AND id_comment";

        $query .= ($id_comment != NULL) ? " = :id_comment" : " IS :id_comment";

        $statement = (new DatabaseConnection())->getConnection()->prepare($query);

        $statement->execute([
            'id_post' => $id_post,
            'id_account' => $id_account,
            'id_comment' => $id_comment,
        ]);
        
        

        $result = $statement->fetch();

        
        if (!$result) { // user didn't react yet
            Reaction::NewReaction($id_account, $id_post, $id_comment, $reaction);
        } else { // user already react
            if ($reaction === 1 && $result['laugh'] == 1) {Reaction::CancelReaction($result['id_reaction']);}
            else if ($reaction === 5 && $result['thumb_up'] == 1) {Reaction::CancelReaction($result['id_reaction']);}
            else if ($reaction === 4 && $result['thumb_down'] == 1) {Reaction::CancelReaction($result['id_reaction']);}
            else if ($reaction === 2 && $result['love'] == 1) {Reaction::CancelReaction($result['id_reaction']);}
            else if ($reaction === 3 && $result['sad'] == 1) {Reaction::CancelReaction($result['id_reaction']);}
            else {Reaction::UpdateReaction($result['id_reaction'], $reaction);}
        }
    }



    public static function NewReaction(int $id_account, int $id_post, ?int $id_comment, int $reaction) {
        new Log("Reaction::NewReaction() of reaction [" . $id_account . $id_post . $id_comment . $reaction . "]");
        $query = "INSERT INTO reactions (`id_reaction`, `thumb_up`, `thumb_down`, `sad`, `love`, `laugh`, `id_account`, `id_comment`, `id_post`) VALUES (NULL, :up, :down, :sad, :love, :laugh, :id_account, :id_comment, :id_post)";
        $statement = (new DatabaseConnection())->getConnection()->prepare($query);
        
        $laugh = 0;
        $love = 0;
        $sad = 0;
        $thumb_down = 0;
        $thumb_up = 0;

        if ($reaction === 1) {$laugh = 1;}
        else if ($reaction === 5) {$thumb_up = 1;}
        else if ($reaction === 4) {$thumb_down = 1;}
        else if ($reaction === 2) {$love = 1;}
        else if ($reaction === 3) {$sad = 1;}

        $statement->execute([
            'up' => $thumb_up,
            'down' => $thumb_down,
            'sad' => $sad,
            'love' => $love,
            'laugh' => $laugh,
            'id_post' => $id_post,
            'id_account' => $id_account,
            'id_comment' => $id_comment
        ]);
    }

    public static function UpdateReaction(int $id_reaction, int $reaction) {
        new Log("Reaction::UpdateReaction() of reaction [" . $id_reaction . $reaction . "]");
        $laugh = 0;
        $love = 0;
        $sad = 0;
        $thumb_down = 0;
        $thumb_up = 0;

        if ($reaction === 1) {$laugh = 1;}
        else if ($reaction === 5) {$thumb_up = 1;}
        else if ($reaction === 4) {$thumb_down = 1;}
        else if ($reaction === 2) {$love = 1;}
        else if ($reaction === 3) {$sad = 1;}


        $query = "UPDATE reactions SET thumb_up = :up, thumb_down = :down, sad = :sad, love = :love, laugh = :laugh WHERE id_reaction = :id_reaction";
        $statement = (new DatabaseConnection())->getConnection()->prepare($query);
        $statement->execute([
            'up' => $thumb_up,
            'down' => $thumb_down,
            'sad' => $sad,
            'love' => $love,
            'laugh' => $laugh,
            'id_reaction' => $id_reaction
        ]);
    }

    public static function CancelReaction(int $id_reaction) {
        new Log("Reaction::CancelReaction() of reaction [" . $id_reaction . "]");
        $query = "DELETE FROM reactions WHERE id_reaction = :id_reaction";
        $statement = (new DatabaseConnection())->getConnection()->prepare($query);
        $statement->execute(['id_reaction' => $id_reaction]);
    }

    public static function DeletePostReaction(int $id_post) {
        new Log("Reaction::DeletePostReaction() on post [" . $id_post . "]");
        $query = "DELETE FROM reactions WHERE id_post = :id_post";
        $statement = (new DatabaseConnection())->getConnection()->prepare($query);
        $statement->execute(['id_post' => $id_post]);
    }

    public static function DeleteCommentsReaction(int $id_comment) {
        new Log("Reaction::DeleteCommentsReaction() on comment [" . $id_comment . "]");
        $query = "DELETE FROM reactions WHERE id_comment = :id_comment";
        $statement = (new DatabaseConnection())->getConnection()->prepare($query);
        $statement->execute(['id_comment' => $id_comment]);
    }
}