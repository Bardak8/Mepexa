<?php
ob_start(); ?>

<link href="style/comments.css" rel="stylesheet" />

<div id="feed">
    <div class="post">
        <ul>
            <li class="post_upper" >
                <p>Published by <a href="/?u=<?= $post->GetAuthor() ?>"> <?= $post->GetAuthor() ?> </a> <?= $post->GetDate() ?> </p>
                <?php if ($post->GetAuthor() == $_SESSION['username']) { ?>
                <button type="button" onclick="location.href='/?close_post=<?= $post->GetId()?>'"  class="btn-close btn-close-white" aria-label="Close" style="width:100px">Delete </button>
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
                    <li>
                        <p onclick="heart_vote()">&#10084</p>
                        <p id="voteHeart">0</p>
                    </li>
                    <li>
                        <p onclick="">&#128077</p>
                        <p>0</p>
                    </li>
                    <li>
                        <p onclick="">&#128078</p>
                        <p>0</p>
                    </li>
                    <li>
                        <p onclick="">&#128514</p>
                        <p>0</p>
                    </li>
                    <li>
                        <p onclick="">&#128546</p>
                        <p>0</p>
                    </li>
                </ul>
                <a href="">
                    0 comments
                </a>
            </li>
        </ul>

        <div id="comment_section">
            <h2>Comments :</h2>
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
                                <a href="/?u=Ben">u/<?=$c->author->GetName() ?></a>
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



