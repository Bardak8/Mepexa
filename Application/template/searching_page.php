<?php $title = "La page de recherche"; ?>

<?php ob_start(); ?>

<h1>Une erreur est survenue : </h1>


<div id="body">
    <?php
    require_once('../src/controller/homepage.php');
    require_once('../src/controller/controller.php');
    $bdd = new \PDO('mysql:host=mepexa;dbname=mapexa;charset=utf8', 'root', '');

    $results = $bdd->query('SELECT * FROM accounts');
    if(isset($_GET['q']) AND !empty($_GET['q'])) {
        $q = htmlspecialchars($_GET['q']);
        $results = $bdd->query('SELECT * FROM accounts WHERE name LIKE "%'.$q.'%" ');
        if($results->rowCount() == 0) {
            $results = $bdd->query('SELECT * FROM accounts WHERE name LIKE "%'.$q.'%" ORDER BY id DESC');
        }
    }
    ?>

    <?php if($results->rowCount() > 0) { ?>
        <h1>Une erreur est survenue : </h1>
        <ul>
            <?php while($a = $results->fetch()) { ?>
                <li><?= $a['name'] ?></li>
            <?php } ?>
        </ul>
    <?php } else { ?>
        <h1>Une erreur est survenue : </h1>
        Aucun résultat pour: <?= $q ?>...
    <?php } ?>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('base.php') ?>