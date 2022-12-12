<?php
ob_start(); ?>
<div id="feed">
    <div class="post">
        <ul>
            <li class="post_upper" onclick="href='/'">
                <p>Published by <a href="/?u=<?= $post->GetAuthor() ?>"> <?= $post->GetAuthor() ?> </a> <?= $post->GetDate() ?> </p>
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
                        <p onclick="">&#10084</p>
                        <p>0</p>
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



