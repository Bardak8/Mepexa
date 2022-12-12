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