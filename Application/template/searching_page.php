

<?php ob_start(); ?>

<link href="style/searching_page.css" rel="stylesheet" />




<div id="searching_zone" >

    <div class="main_title_search">
        <?php if(empty($search_terms)) { ?>
        <h2>No results</h2>
        <?php } else { ?>
        <h2>Results for "<?= $search_terms ?>"</h2>
        <?php } ?>
    </div>

    <div id="search_result">
        <?php if($results->rowCount() > 0) { ?>
            <ul>
                <?php foreach ($results as $result) { ?>

                        <li><a href="/?u=<?=$result['name'] ?>"><?= $result['name'] ?></a></li>

                <?php } ?>
            </ul>
        <?php } elseif (empty($search_terms)) { ?>
            Waiting for your search...
        <?php } else { ?>
            Aucun résultat pour: <?= $q ?>...
        <?php } ?>
    </div>
</div>

<?php
$content = ob_get_clean();
require('template/base.php')
?>