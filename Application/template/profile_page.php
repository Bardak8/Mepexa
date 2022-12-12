<?php ob_start(); ?>

<link href="style/profil_page.css" rel="stylesheet" />

<div id="info_account">
    <p id="pseudo"> <?= $account->GetName() ?> </p>
    <?php if ($private) { ?>
        <table>
            <tr>
                <td>Email :</td>
                <td><?= $account->GetEmail() ?></td>
            </tr>
            <tr>
                <td>
                    <a href="" style="font-size: 10px; color: #efbc32">change password</a>
                </td>
            </tr>
        </table>
    <?php } else { ?>
        <form method="POST">
            <input type="hidden" name="request_id" value="<?= $account->GetId() ?>">
            <input type="hidden" name="friend_request" value="new">

            <?php if (!$is_friend && !$has_pending_request) { ?>
                <input type="submit" value="Add friend">
            <?php } else if ($has_pending_request) { ?>
                <p>pending request...</p>
            <?php } ?>
        
        </form>
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
                        <form method="POST">
                            <input type="hidden" name="request_id" value="<?= $request->GetSender()->GetId() ?>">
                            <input type="hidden" name="friend_request" value="accept">
                            <input type="submit" value="accept">
                        </form>
                        <form method="POST">
                            <input type="hidden" name="request_id" value="<?= $request->GetSender()->GetId() ?>">
                            <input type="hidden" name="friend_request" value="refuse">
                            <input type="submit" value="refuse">
                        </form>
                    </div>
                    
                </li>
            <?php }  ?>



            <?php foreach ($receive_requests->GetPendingRequests() as $request) { ?>
                <li>
                    <a href="?u=<?= $request->GetReceiver()->GetName() ?>">
                        <?= $request->GetReceiver()->GetName() ?>
                    </a>
                    <p>pending ...</p>
                    <form method="POST">
                        <input type="hidden" name="request_id" value="<?= $request->GetReceiver()->GetId() ?>">
                        <input type="hidden" name="friend_request" value="abort">
                        <input type="submit" value="abort">
                    </form>
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
                    <?php if ($_GET['u'] == $controller->GetAccount()->GetName()) { ?>
                        <form method="POST">
                            <input type="hidden" name="request_id" value="<?= $friend->GetId() ?>">
                            <input type="hidden" name="friend_request" value="delete">
                            <input type="submit" value="delete">
                        </form>
                    <?php } ?>
                </li>
            <?php } ?>
        </ul>
    </div>

    <div class="feed">
        <h2 class="title">
            Posts
        </h2>

        <?php foreach ($feed->GetPosts() as $post) { ?>
    
    <div class="post" onclick="location.href='/?post=<?= $post->GetId()?> '">
        <ul>
            <li class="post_upper" onclick="location.href='/?post=<?= $post->GetId()?> '">
                <p>Published by <a href="/?u=<?= $post->GetAuthor() ?>"> <?= $post->GetAuthor() ?> </a> <?= $post->GetDate() ?> </p>
            </li>
            <li class="post_title" onclick="location.href='/?post=<?= $post->GetId()?> '">
                <h2><?= $post->GetTitle() ?></h2>
            </li>
            
            <?php if ($post->GetMediaPath() != null) { ?>
                <li class="post_content" style="display: flex; justify-content: center;" onclick="location.href='/?post=<?= $post->GetId()?> '">
                    <img class="post_image" src=" uploads/<?= $post->GetMediaPath() ?>" alt="post content">
                </li>
            <?php } else { ?>
                <li class="post_content" onclick="location.href='/?post=<?= $post->GetId()?> '">
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

<?php }
    
    if (count($feed->GetPosts()) == 0) { ?>

        <div class="post"></div>

<?php } ?>


    </div>
</div>

<?php 
    $content = ob_get_clean();
    require('template/base.php') 
?>