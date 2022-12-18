<?php
ob_start(); ?>

<link href="style/comments.css" rel="stylesheet" />

<div id="feed">
    <div class="post">
        <ul>
            <li class="post_upper" >
                <p>Published by <a href="/?u=<?= $post->GetAuthor() ?>"> <?= $post->GetAuthor() ?> </a> <?= $post->GetDate() ?> </p>
                <?php if ($post->GetAuthor() == $_SESSION['username']) { ?>
                <button type="button" onclick="location.href='/?close_post=<?= $post->GetId()?>'"  class="btn-close btn-close-white" aria-label="Close" style="width:100px">Delete</button>
                <?php }?>
            </li>
            <li class="post_title" >
                <h2><?= $post->GetTitle() ?></h2>
            </li>

            <?php if ($post->GetMediaPath() != null) { ?>
                <li class="post_content" style="display: flex; justify-content: center;" >
                    <img class="post_image" src=" uploads/<?= $post->GetMediaPath() ?>" alt="post content">
                </li>
            <?php }?>
                <li class="post_content" >
                    <p><?= $post->GetContent() ?></p>
                </li>
            <li class="post_footer">

                <ul class="post_reactions">
                    <form method="POST">
                        <input type="hidden" name="id_post_reaction" value="<?=$post->GetId()?>">
                        <input type="hidden" name="reaction_type" value="2">
                        <button type="submit" class="reaction_button">
                            <img src="image/love.png" alt="" class="reaction_image">
                        </button>
                        <p id="voteHeart"><?= $post_reactions->love ?></p>
                    </form>

                    <form method="POST">
                        <input type="hidden" name="id_post_reaction" value="<?=$post->GetId()?>">
                        <input type="hidden" name="reaction_type" value="5">
                        <button type="submit" class="reaction_button">
                            <img src="image/thumb-up.png" alt="" class="reaction_image">
                        </button>
                        <p><?= $post_reactions->thumb_up ?></p>
                    </form>

                    <form method="POST">
                        <input type="hidden" name="id_post_reaction" value="<?=$post->GetId()?>">
                        <input type="hidden" name="reaction_type" value="4">
                        <button type="submit" class="reaction_button">
                            <img src="image/thumb-down.png" alt="" class="reaction_image">
                        </button>
                        <p><?= $post_reactions->thumb_down ?></p>
                    </form>

                    <form method="POST">
                        <input type="hidden" name="id_post_reaction" value="<?=$post->GetId()?>">
                        <input type="hidden" name="reaction_type" value="1">
                        <button type="submit" class="reaction_button">
                            <img src="image/laugh.png" alt="" class="reaction_image">
                        </button>
                        <p><?= $post_reactions->laugh ?></p>
                    </form>

                    <form method="POST">
                        <input type="hidden" name="id_post_reaction" value="<?=$post->GetId()?>">
                        <input type="hidden" name="reaction_type" value="3">
                        <button type="submit" class="reaction_button">
                            <img src="image/cry.png" alt="" class="reaction_image">
                        </button>
                        <p><?= $post_reactions->sad ?></p>
                    </form>
                </ul>

            </li>
        </ul>

        <div id="comment_section">
            <h2><?= count($comment_list->comments)  ?> Comments :</h2>
            <form method="post" name="create_comment">
                <textarea name="comment_content" id="comment_content" rows="5" maxlength="120" required></textarea>
                <input type="submit" value="Submit">
            </form>

            <ul>
                <?php foreach($comment_list->comments as $c) { ?>
                    <li>
                        <div class="comment">
                            <div class="header">
                                <img src="style/image/default.png" alt="author pp">
                                <a href="/?u=<?= $c->author->GetName() ?>">
                            </div>
                            <div class="footer">
                                <div class="bar_container">
                                    <div class="bar"></div>
                                </div>
                                <div class="content">
                                    <div class="comment_text"><?=$c->content ?></div>
                                    <div class="content_footer" id="comment_0">
                                        <div class="close_comment" >
                                        <?php if ($c->author->GetName()  == $_SESSION['username']) { ?>
                                            <button type="button" onclick="location.href='/?close_comment=<?= $c->GetId()?>'"  class="btn-close btn-close-white" aria-label="Close" style="width:100px">Delete </button>
                                        <?php }?>
                                        </div>
                                </div>
                                <ul class="comment_reactions">
                                    <form method="POST">
                                        <input type="hidden" name="id_post_reaction" value="<?=$post->GetId()?>">
                                        <input type="hidden" name="id_comm_reaction" value="<?=$c->id?>">
                                        <input type="hidden" name="reaction_type" value="2">
                                        <button type="submit" class="reaction_button">
                                            <img src="image/love.png" alt="" class="reaction_image">
                                        </button>
                                        <p><?= $c->reaction->love ?></p>
                                    </form>

                                    <form method="POST">
                                        <input type="hidden" name="id_post_reaction" value="<?=$post->GetId()?>">
                                        <input type="hidden" name="id_comm_reaction" value="<?=$c->id?>">
                                        <input type="hidden" name="reaction_type" value="5">
                                        <button type="submit" class="reaction_button">
                                            <img src="image/thumb-up.png" alt="" class="reaction_image">
                                        </button>
                                        <p><?= $c->reaction->thumb_up ?></p>
                                    </form>

                                    <form method="POST">
                                        <input type="hidden" name="id_post_reaction" value="<?=$post->GetId()?>">
                                        <input type="hidden" name="id_comm_reaction" value="<?=$c->id?>">
                                        <input type="hidden" name="reaction_type" value="4">
                                        <button type="submit" class="reaction_button">
                                            <img src="image/thumb-down.png" alt="" class="reaction_image">
                                        </button>
                                        <p><?= $c->reaction->thumb_down ?></p>
                                    </form>

                                    <form method="POST">
                                        <input type="hidden" name="id_post_reaction" value="<?=$post->GetId()?>">
                                        <input type="hidden" name="id_comm_reaction" value="<?=$c->id?>">
                                        <input type="hidden" name="reaction_type" value="1">
                                        <button type="submit" class="reaction_button">
                                            <img src="image/laugh.png" alt="" class="reaction_image">
                                        </button>
                                        <p><?= $c->reaction->laugh ?></p>
                                    </form>

                                    <form method="POST">
                                        <input type="hidden" name="id_post_reaction" value="<?=$post->GetId()?>">
                                        <input type="hidden" name="id_comm_reaction" value="<?=$c->id?>">
                                        <input type="hidden" name="reaction_type" value="3">
                                        <button type="submit" class="reaction_button">
                                            <img src="image/cry.png" alt="" class="reaction_image">
                                        </button>
                                        <p><?= $c->reaction->sad ?></p>
                                    </form>
                                </ul>
                            </div>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require('template/base.php')
?>



