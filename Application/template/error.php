<?php $title = "ERROR"; ?>

<?php ob_start(); ?>

    <link href="../style/error.css" rel="stylesheet" />

<h1>Une erreur est survenue : <?= $errorMessage ?></h1>
<a href="/">Homepage</a>
<?php $content = ob_get_clean(); ?>

<?php require('base.php') ?>