<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?= $title ?></title>
        <link href="style/main.css" rel="stylesheet" />
        <link href="style/post.css" rel="stylesheet" />
    </head>

    <body>
        <?php require('template/components/header.php') ?>
        <div id="body">
            <?= $content ?>
            <?php require('template/components/side_bar.php') ?>
        </div>
    </body>
</html>
