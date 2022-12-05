<?php ob_start(); ?>

<link href="style/profil_page.css" rel="stylesheet" />

<div id="info_account">
    <p id="pseudo"> <?= $account->GetName() ?> </p>

    <?php if ($private) { ?>
        <table>
            <tr>
                <td>Password :</td>
                <td>
                    **********
                    <a href="" style="font-size: 10px; color: #efbc32">change password</a>
                </td>
            </tr>
            <tr>
                <td>Email :</td>
                <td>noupie@gmail.com</td>
            </tr>
            <tr>
                <td>Birthday :</td>
                <td>01/02/1990</td>
            </tr>
        </table>
    <?php } ?>

</div>

<div>
    <div id="friends_menu">
    <?php if ($private) { ?>
        <h2 class="title">
            Request list
        </h2>

        <ul id="request_list">
            <?php foreach ($sended_requests->GetPendingRequests() as $request) { ?>
                <li>
                    <a href="?u=<?= $request->GetSender()->GetName() ?>">
                        <?= $request->GetSender()->GetName() ?>
                    </a>
                    <div>
                        <img src="../image/accept.svg" alt="accept" onclick="">
                        <img src="../image/refuse.svg" alt="refuse" onclick="">
                    </div>
                </li>
            <?php } ?>



            <?php foreach ($receive_requests->GetPendingRequests() as $request) { ?>
                <li>
                    <a href="?u=<?= $request->GetReceiver()->GetName() ?>">
                        <?= $request->GetReceiver()->GetName() ?>
                    </a>
                    <p>pending ...</p>
                </li>
            <?php } ?>
        </ul>
        <?php } ?>

        <h2 class="title">
            Friend list
        </h2>

        <ul id="friend_list">
            <?php foreach ($friends->GetFriends() as $friend) { ?>
                <li>
                    <a href="/?u=<?= $friend->GetName() ?>">
                        <?= $friend->GetName() ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>

    <div class="feed">
        <h2 class="title">
            Posts
        </h2>

        <?php foreach ($feed->GetPosts() as $post) { ?>
    
    <div class="post">
        <ul>
            <li class="post_upper" onclick="href=''">
                <p>Published by <a href="/?u=<?= $post->GetAuthor() ?>"> <?= $post->GetAuthor() ?> </a> <?= $post->GetDate() ?> </p>
            </li>
            <li class="post_title" onclick="href=''">
                <h2><?= $post->GetTitle() ?></h2>
            </li>
            
            <?php if ($post->GetMediaPath() != null) { ?>
                <li class="post_content" style="display: flex; justify-content: center;" onclick="location.href=''">
                    <img class="post_image" src=" uploads/<?= $post->GetMediaPath() ?>" alt="post content">
                </li>
            <?php } else { ?>
                <li class="post_content" onclick="href=''">
                    <p><?= $post->GetContent() ?></p>
                </li>
            <?php } ?>
            <li class="post_footer">
                <ul class="post_reactions">
                    <li>
                        <p onclick="">&#10084</p>
                        <p>0</p>
                    </li>
                    <li>
                        <p onclick="">&#128077</p>
                        <p>0</p>
                    </li>
                    <li>
                        <p onclick="">&#128078</p>
                        <p>0</p>
                    </li>
                    <li>
                        <p onclick="">&#128514</p>
                        <p>0</p>
                    </li>
                    <li>
                        <p onclick="">&#128546</p>
                        <p>0</p>
                    </li>
                </ul>
                <a href="">
                    0 comments
                </a>
            </li>
        </ul>
    </div>

<?php } ?>


    </div>
</div>

<?php 
    $content = ob_get_clean();
    require('template/base.php') 
?>