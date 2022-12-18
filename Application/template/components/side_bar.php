<div id="side_bar">
    <?php if ($controller->IsConnected()) { ?>

        <div id="main_menu" class="menu">
            <div class="box">
                <ul>
                    <li>
                        <img src="../image/v2.png" alt="mepexa logo" style="border-radius: 999999px;">
                        <h3>Home</h3>
                    </li>
                    <li>
                        <p>Your personnal Mepexa home page. Come here to consult all your favorites posts.</p>
                    </li>
                    <li>
                        <div id="create_post_bt" class="button highlight_bt" onclick="location.href='/?new'">
                            <p>Create post</p>
                        </div>
                    </li>
                    <li>
                        <form action="" method="post" id="signup">
                            <button type="submit" name="disconnect" id="signup" class="button" onclick="">
                                <p>Disconnect</p>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

    <?php } else { ?>

        <div id="main_menu" class="menu">
            <div class="box">
                <ul>
                    <li>
                        <img src="../image/v2.png" alt="mepexa logo" style="border-radius: 999999px;">
                        <h3>Home</h3>
                    </li>
                    <li>
                        <p>Your personnal Mepexa home page. Come here to consult all your favorites posts.</p>
                    </li>
                    <li>
                        <div id="create_post_bt" class="button highlight_bt" onclick="open_signup_menu()">
                            <p>Sign up</p>
                        </div>
                    </li>
                    <li>
                        <div id="signup" class="button" onclick="open_signin_menu()">
                            <p>Login</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div id="signup_menu" class="menu sign">
            <div>
                <img src="../image/v2.png" alt="mepexa logo" style="border-radius: 999999px;">
                <h3>Sign up</h3>
            </div>
            <form action="/" method="POST">
                <table>
                    <tr>
                        <td>
                            <label for="username">Username / Email</label>
                        </td>
                        <td>
                            <input type="text" name="username" id="username" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="email">Email</label>
                        </td>
                        <td>
                            <input type="email" name="email" id="email" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="password">Password</label>
                        </td>
                        <td>
                            <input type="password" name="password" id="password" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="password_confirm">Confirm password</label>
                        </td>
                        <td>
                            <input type="password" name="password_confirm" id="password_confirm" required>
                        </td>
                    </tr>
                </table>
                <input class="button highlight_bt" type="submit" value="Sign up">
                <div class="button" type="submit" onclick="open_main_menu()">
                    <p>Back</p>
                </div>
            </form>
        </div>

        <div id="signin_menu" class="menu sign">
            <div>
                <img src="../image/v2.png" alt="mepexa logo" style="border-radius: 999999px;">
                <h3>Sign in</h3>
            </div>
            <form action="" method="POST">
                <table>
                    <tr>
                        <td>
                            <label for="username">Username</label>
                        </td>
                        <td>
                            <input type="text" name="username" id="username" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="password">Password</label>
                        </td>
                        <td>
                            <input type="password" name="password" id="password" required>
                        </td>
                    </tr>
                </table>
                <input class="button highlight_bt" type="submit" value="Login">
                <div class="button" type="submit" onclick="open_main_menu()">
                    <p>Back</p>
                </div>
            </form>
        </div>

    <?php } ?>

    <div id="second-menu" class="menu">
        <ul>
            <li><a href="haha, no">Report a problem</a></li>
            <li><a href="no privacy, no policy">Privacy policy</a></li>
            <li><a href="">Authors</a></li>
            <br>
            <li><p id="Mepexa">Mepeжa Inc © 2022. Tous droits réservés</p></li>
        </ul>
    </div>
</div>