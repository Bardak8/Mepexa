<?php
namespace Application\Model\Reaction;

require_once('src/pdo/database.php');
require_once('src/model/account.php');
require_once('src/model/friend.php');

class Reaction
{
    private ?int $id;
    private int $id_account;
    private int $id_comment;
    private int $id_post;
    private int $laugh;
    private int $love;
    private int $sad;
    private int $thumb_down;
    private int $thumb_up;

    public function __construct(?int $id, int $id_account, int $id_comment, int $id_post, int $laugh, int $love, int $sad, int $thumb_down, int $thumb_up)
    {
        $this->id = $id;
        $this->id_account = $id_account;
        $this->id_comment = $id_comment;
        $this->id_post = $id_post;
        $this->laugh = $laugh;
        $this->love = $love;
        $this->sad = $sad;
        $this->thumb_down = $thumb_down;
        $this->thumb_up = $thumb_up;
    }

    public static function UploadReaction(int $id_account, int $id_comment, int $id_post) {

        $db = new DatabaseConnection();
        $connection = $db->getConnection();









    }
}