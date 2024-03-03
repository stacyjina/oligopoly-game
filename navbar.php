<div class="navbar">
        <div class="nav container"> 
            <div class="brand"> 
                <a class="brand" href="./index.php"> 
                    <span class="brandname">The Oligopoly Game</span> 
                </a>
            </div>

            <ul class="nav buttons"> 
                <li class="nav link"> 
                    <a href="./index.php">Home</a>
                </li>
                <li class="nav link"> 
                    <?php 
                        if (isset($_SESSION['login'])) {
                            include("logout_button.html");
                        } else {
                            include("login_button.php");
                        }
                    ?>
                </li>
                <li class="nav link"> 
                    <a href="#">About</a>
                </li>
            </ul>
        </div>

</div>