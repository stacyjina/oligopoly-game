<div class="navbar">
        <div class="nav container"> 

            <!-- Name of the game -->

            <div class="brand"> 
                <a class="brand" href="./index.php"> 
                    <span class="brandname">The Oligopoly Game</span> 
                </a>
            </div>

            <!-- Navigation buttons -->

            <ul class="nav buttons"> 
                <li class="nav link"> 
                    <a href="./index.php">Home</a>
                </li>
                <li class="login nav link" id="login"> 
                    <?php 
                        if (isset($_SESSION['login'])) {
                            include("logout_button.html");
                        } else {
                            include("login_button.php");
                        }
                    ?>
                </li>

                <!-- Login form -->
                
                <ul class="dropdown-menu closed" role="menu" id="login-form">
                    <div id="fast-login-form-area">
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
                    </div>
                </ul>
                <li class="nav link"> 
                    <a href="./about.php">About</a>
                </li>
            </ul>
        </div>
</div>