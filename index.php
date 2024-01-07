<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>The Oligopoly Game</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='css/style.css'>
    <!-- <link rel='stylesheet' type='text/css' media='screen' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css'> -->
    <!-- <script src='main.js'></script> -->
</head>
<body>
    
    <!-- Navigation bar -->

    <div class="navbar">
        <div class="nav container"> 
            <div class="brand"> 
                <a class="brand" href="#"> 
                    <span class="brandname">The Oligopoly Game</span> 
                </a>
            </div>

            <ul class="nav buttons"> 
                <li class="nav link"> 
                    <a href="#">Home</a>
                </li>
                <li class="nav link"> 
                    <a href="#" class="dropdown-toggle" role="button" aria-expanded="false">
                        Login</span>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li id="fast-login-form-area">
                            <form id="loginFormItem" name="f" action="index.php" method="POST" class="dropdown-menus ng-pristine ng-valid">
                                
                                <div class="form-group">
                                    <label for="loginInputField">Login</label>
                                    <br>
                                    <input id="loginInputField" type="text" name="j_username" style="text-align: center" value="login">
                                </div>
                                <div class="form-group">
                                    <label for="passwordInputField">Password</label>
                                    <br>
                                    <input id="passwordInputField" type="password" name="j_password" style="text-align: center" value="password">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success btn-block">Login</button>
                                </div>
                            </form>
                        </li>
                    </ul>
                </li>
                <li class="nav link"> 
                    <a href="#">About</a>
                </li>
            </ul>
        </div>

    </div>

    <!-- Title -->

    <h1 class="title">The Oligopoly Game</h1>

    <div class="description">
        <p>This is a multiplayer economic game that will teach you the way oligopolies work and 
            will get you acquainted with the prisoner's dilemma.</p>
    </div>

    <div class="new-or-existing">
        <p>If you are an instructor press the button below to create a new game. 
            If you want to enter an existing game -- log in via the top bar.</p>
    </div>

    <button class="new-game" type="menu">New game</button>

    <div class="dropdown-form">
        <form class="px-4 py-3" action="index.php" method="post">
            <div class="mb-3">
                <label for="exampleDropdownFormEmail1" class="form-label">Name of the game</label>
                <br>
                <input type="text" placeholder="my game" name="gamename">
            </div>
            <div class="mb-3">
                <label class="label" for="players_number">Players</label>
                <br>
                <select name="players_number">
                    <option value="3" style="text-align: center;">3</option>
                    <option value="4" style="text-align: center;">4</option>	
                    <option value="5" selected="selected" style="text-align: center;">5</option>	
                    <option value="6" style="text-align: center;">6</option>				
                </select>            
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Create a game</button>
        </form>
    </div>

    <div class="logins">
        <?php
            if (isset($_POST["submit"])) {
                foreach ($_POST as $key => $value) {
                    echo "{$key} -> {$value} <br>";
                }
                for ($i = 1; $i <= $_POST["players_number"]; $i++) {
                    echo "login{$i}: {$_POST["gamename"]}{$i} <br>";
                }
            }
        ?>
        <!-- <ul class="logins">
            <li></li>
        </ul> -->
    </div>
</body>
</html>