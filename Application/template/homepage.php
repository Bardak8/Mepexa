<?php ob_start(); ?>

<div class="feed">

<?php foreach ($feed->GetPosts() as $post) { ?>
    
<div class="post">
    <ul>
        <li class="post_upper" onclick="href=''">
            <p>Published by <a href="/"> <?= $post->GetAuthor() ?> </a> <?= $post->GetDate() ?> </p>
        </li>
        <li class="post_title" onclick="href=''">
            <h2><?= $post->GetTitle() ?></h2>
        </li>
        
        <?php if ($post->GetMediaPath() != "null") { ?>
            <li class="post_content" style="display: flex; justify-content: center;" onclick="location.href=''">
                <img class="post_image" src="<?= $post->GetMediaPath() ?>" alt="post content">
            </li>
        <?php } else { ?>
            <li class="post_content" onclick="href=''">
                <p><?= $post->GetContent() ?></p>
            </li>
        <?php } ?>
    </ul>
</div>

<?php } ?>

</div>

<?php 
    $content = ob_get_clean();
    require('template/base.php') 
?>