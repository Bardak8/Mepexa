<div id="header">
    <h1>Мережа</h1>
    <form class="post search_result">
        <input type="text" placeholder="searching-bar">
        <input type="submit">
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