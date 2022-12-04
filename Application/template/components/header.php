<div id="header">
    <h1 onclick="location.href='/'">
        Мережа
    </h1>

    <form id="search_form" METHOD="get" action="/">
        <input type="text" placeholder="Your search..." id="search_bar" name="search_terms"/>
        <input type="submit" id="search_submit" value="Search" />
    </form>

    <div id="connexion-zone">
        <?php if ($controller->IsConnected()) { ?>
            <img id="profile_picture" src="../style/image/default.png" alt="connexion" onclick='location.href="?u=<?= $controller->GetAccount()->GetName() ?>"'>
            <p onclick='location.href="?u=<?= $controller->GetAccount()->GetName() ?>"'>
                <?= $controller->GetAccount()->GetName(); ?>
            </p>
        <?php } else { ?>
            <a href="">Sign up</a>
            <a href="">Sign in</a>
        <?php }?>
    </div>
</div>