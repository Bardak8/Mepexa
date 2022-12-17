<?php ob_start(); ?>

<div id="feed">

<?php foreach ($feed->GetPosts() as $post) { ?>
    
    <div class="post" onclick="location.href='/?post=<?= $post->GetId()?> '">
        <ul>
            <li class="post_upper" ">
                <p>Published by <a href="/?u=<?= $post->GetAuthor() ?>"> <?= $post->GetAuthor() ?> </a> <?= $post->GetDate() ?> </p>
            </li>
            <li class="post_title" >
                <h2><?= $post->GetTitle() ?></h2>
            </li>
            
            <?php if ($post->GetMediaPath() != null) { ?>
                <li class="post_content" style="display: flex; justify-content: center;" >
                    <img class="post_image" src=" uploads/<?= $post->GetMediaPath() ?>" alt="post content">
                </li>
            <?php } else { ?>
                <li class="post_content" >
                    <p><?= $post->GetContent() ?></p>
                </li>
            <?php } ?>
            <li class="post_footer">
            <ul class="post_reactions">
                    <form method="POST">
                        <input type="hidden" name="id_post_reaction" value="<?=$post->GetId()?>">
                        <input type="hidden" name="reaction_type" value="2">
                        <button type="submit" class="reaction_button">
                            <img src="image/love.png" alt="" class="reaction_image">
                        </button>
                        <p id="voteHeart"><?= $post->reaction->love ?></p>
                    </form>

                    <form method="POST">
                        <input type="hidden" name="id_post_reaction" value="<?=$post->GetId()?>">
                        <input type="hidden" name="reaction_type" value="5">
                        <button type="submit" class="reaction_button">
                            <img src="image/thumb-up.png" alt="" class="reaction_image">
                        </button>
                        <p><?= $post->reaction->thumb_up ?></p>
                    </form>

                    <form method="POST">
                        <input type="hidden" name="id_post_reaction" value="<?=$post->GetId()?>">
                        <input type="hidden" name="reaction_type" value="4">
                        <button type="submit" class="reaction_button">
                            <img src="image/thumb-down.png" alt="" class="reaction_image">
                        </button>
                        <p><?= $post->reaction->thumb_down ?></p>
                    </form>

                    <form method="POST">
                        <input type="hidden" name="id_post_reaction" value="<?=$post->GetId()?>">
                        <input type="hidden" name="reaction_type" value="1">
                        <button type="submit" class="reaction_button">
                            <img src="image/laugh.png" alt="" class="reaction_image">
                        </button>
                        <p><?= $post->reaction->laugh ?></p>
                    </form>

                    <form method="POST">
                        <input type="hidden" name="id_post_reaction" value="<?=$post->GetId()?>">
                        <input type="hidden" name="reaction_type" value="3">
                        <button type="submit" class="reaction_button">
                            <img src="image/cry.png" alt="" class="reaction_image">
                        </button>
                        <p><?= $post->reaction->sad ?></p>
                    </form>
                </ul>
            </li>
        </ul>
    </div>



<?php } ?>

<?php

for ($i = 1; $i <= $nbPages; $i++) {
    ?>
    <a href="/?page=<?=$i;?>"><?=$i;?></a>
    <?php
}
?>
</div>



<?php 
    $content = ob_get_clean();
    require('template/base.php') 
?>