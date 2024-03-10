<a href="#" class="dropdown-toggle" role="button" aria-expanded="false">
    Login</span>
    <span class="caret"></span>
</a>
<ul class="dropdown-menu" role="menu">
    <?php
        if (isset($_POST["submit2"])) {
            if (!empty($_POST["username"]) && !empty($_POST["password"])) {
                $login = $_POST["username"];
                $password = $_POST["password"];
                $query = "select count(*) from players where login = '{$login}' and password = '{$password}';";
                $res = mysqli_query($conn, $query)->fetch_all()[0][0];
                if ($res != 0) {
                    $_SESSION["login"] = $login;
                    $_SESSION["gamename"] = $password;
                    $_SESSION["round"] = 1;
                    header("Location: game_page.php");
                }
                else {
                    echo "<li> <div> Incorrect login/password. </div> </li>";
                }
            } else {
                echo "<li> <div> Please enter both login and password. </div> </li>";
            }
        }
    ?>
    <li id="fast-login-form-area">
        <form id="loginFormItem" name="f" action="index.php" method="POST" class="dropdown-menus ng-pristine ng-valid">
            
            <div class="form-group">
                <label for="loginInputField">Login</label>
                <br>
                <input id="loginInputField" type="text" name="username" style="text-align: center" placeholder="login">
            </div>
            <div class="form-group">
                <label for="passwordInputField">Password</label>
                <br>
                <input id="passwordInputField" type="password" name="password" style="text-align: center" placeholder="password">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success btn-block" name="submit2">Login</button>
            </div>
        </form>
    </li>
</ul>