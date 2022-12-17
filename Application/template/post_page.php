<?php
ob_start(); ?>
<div id="feed">
    <div class="post">
        <ul>
            <li class="post_upper" onclick="href='/'" >
                <p>Published by <a href="/?u=<?= $post->GetAuthor() ?>"> <?= $post->GetAuthor() ?> </a> <?= $post->GetDate() ?> </p>
                <?php if ($post->GetAuthor() == $_SESSION['username']) { ?>
                <button type="button" onclick="location.href='/?close_post=<?= $post->GetId()?>'"  class="btn-close btn-close-white" aria-label="Close" style="width:100px">Delete </button>
                <?php }?>
            </li>
            <li class="post_title" onclick="href='/'">
                <h2><?= $post->GetTitle() ?></h2>
            </li>

            <?php if ($post->GetMediaPath() != null) { ?>
                <li class="post_content" style="display: flex; justify-content: center;" onclick="location.href='/'">
                    <img class="post_image" src=" uploads/<?= $post->GetMediaPath() ?>" alt="post content">
                </li>
            <?php }?>
                <li class="post_content" onclick="href='/'">
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
    </div>
</div>

<?php
$content = ob_get_clean();
require('template/base.php')
?>



