<?php 
    // Database connection file
    require_once("db.php");

    // Starting a session to keep track of users
    session_start();

    // Check for invalid login info
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
                echo "<div class='error'> Incorrect login/password. </div>";
            }
        } else {
            echo "<div class='error'> Please enter both login and password. </div>";
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>The Oligopoly Game</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='css/style.css'>
</head>
<body>
    
    <!-- Navigation bar -->

    <?php 
        include("navbar.php");
    ?>

    <!-- Title and description -->

    <h1 class="title">The Oligopoly Game</h1>

    <div class="description main">
        <p>This is a multiplayer economic game that will teach you the way oligopolies work and 
            <br>will get you acquainted with the prisoner's dilemma.</p>
    </div>

    <div class="new-or-existing main">
        <p>If you are an instructor press the button below to create a new game. 
            <br>If you want to enter an existing game -- log in via the top bar.</p>
    </div>

    <!-- Form to create a new game -->

    <div class="form homepage">
        <h3> Create a new game </h3>
        <form class="create" action="index.php" method="post">
            <div class="mb-3">
                <label class="create">Name of the game</label>
                <br>
                <input class="create" type="text" placeholder="my game" name="gamename">
            </div>
            <div class="mb-3">
                <label class="create" for="players_number">Players</label>
                <br>
                <select class="create" name="players_number">
                    <option value="2" style="text-align: center;">2</option>
                    <option value="3" style="text-align: center;">3</option>
                    <option value="4" selected="selected" style="text-align: center;">4</option>	
                    <option value="5" style="text-align: center;">5</option>	
                    <option value="6" style="text-align: center;">6</option>				
                </select>            
            </div>
            <button type="submit" class="create" name="submit">Create a game</button>
        </form>
    </div>

    <!-- Container with logins and password for a newly created game -->

    <div class="logins homepage">
        <?php
            if (isset($_POST["submit"])) {
                $gamename = $_POST["gamename"];
                $query = "insert into gamenames (name) values ('{$gamename}')";
                mysqli_query($conn, $query);
                $query = "select count(*) from gamenames where name = '{$gamename}'";
                $res = mysqli_query($conn, $query)->fetch_all()[0][0];
                $gamename .= "{$res}";
                echo"<p>These are your logins for entering the game: <br>";
                for ($i = 1; $i <= $_POST["players_number"]; $i++) {
                    echo "login{$i}: {$gamename}_{$i} <br>";
                    $query = "insert into players (login, password) values ('{$gamename}_{$i}', '{$gamename}');";
                    mysqli_query($conn, $query);
                }
                echo "Password is <strong>{$gamename}</strong>. </p>";
                $query = "insert into games (gamename, cur_round, num_players) values ('{$gamename}', 1, {$_POST["players_number"]})";
                mysqli_query($conn, $query);
            }
        ?>
    </div>

    <!-- Scripts for jquery, ajax -->

    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="js/action.js"></script>

</body>
</html>