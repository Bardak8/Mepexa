<?php ob_start(); ?>

<link href="style/new_post.css" rel="stylesheet" />


<form id="new_post" action="/" method="POST" enctype="multipart/form-data" >
    <h1>
        New post
    </h1>
    <ul>
        <li>
            <label for="post_title">Title :</label>
            <input type="text" name="post_title" id="post_title" placeholder="Some interesting title" required>
        </li>

        <li>
            <label for="post_content">Content :</label>
            <textarea name="post_content" id="post_content" cols="30" rows="10" placeholder="Post content" required></textarea>
        </li>

        <li>
            <label for="post_media">Media :</label>
            <input type="file" name="post_media" id="post_media" accept="image/*">
        </li>
    </ul>

    <input type="submit" value="Publish">
</form>

<?php 
    $content = ob_get_clean();
    require('template/base.php') 
?>