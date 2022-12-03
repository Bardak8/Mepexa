<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8" />
        <title><?= $title ?></title>
        <link rel="icon" type="image/x-icon" href="/image/favicon.ico">
        <link href="style/main.css" rel="stylesheet" />
        <link href="style/post.css" rel="stylesheet" />
        <script src="script/main.js"></script>
    </head>

    <body>
        <?php require('components/header.php') ?>
        <div id="body">
            <?= $content ?>
            <?php require('components/side_bar.php') ?>
        </div>
    </body>
    
</html>
