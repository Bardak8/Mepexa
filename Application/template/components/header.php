<div id="header">
    <h1 onclick="location.href='/'">Мережа</h1>
    <form id="search_form">
        <input type="text" placeholder="Your search..." id="search_bar">
        <input type="submit" id="search_submit" value="Search">
    </form>
    <div id="connexion-zone">
        <?php if ($controller->IsConnected()) { ?>
            <img id="profile_picture" src="../style/image/default.png" alt="connexion">
            <p>
                <?= $controller->GetAccount()->GetName(); ?>
            </p>
        <?php } else { ?>
            <a href="">Sign up</a>
            <a href="">Sign in</a>
        <?php }?>
    </div>
</div>