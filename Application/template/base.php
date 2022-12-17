<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8" />
        <title><?= $title ?></title>
        <link rel="icon" type="image/x-icon" href="/image/favicon.ico">
        <link href="style/main.css" rel="stylesheet" />
        <link href="style/post.css" rel="stylesheet" />
        <script src="script/main.js"></script>
        <script src="script/reaction.js"></script>
    </head>

    <body>
        <?php require('components/header.php') ?>
        <div id="body">
            <?= $content ?>
            <?php 
            if (!isset($_GET['u']) && !isset($_GET['search_terms'])) {   // if user is on a profile page, don't show the sodebar
                require('components/side_bar.php');
            } 
            ?>
        </div>  
    </body>
    
</html>
