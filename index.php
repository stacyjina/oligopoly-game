<?php 
    require_once("db.php");
    session_start();
?>

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

    <?php 
        include("navbar.php");
    ?>
    <!-- <div class="navbar">
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

    </div> -->

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

    <!-- <button class="new-game" type="menu">New game</button> -->

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
                $gamename = $_POST["gamename"];
                $query = "insert into gamenames (name) values ('{$gamename}')";
                mysqli_query($conn, $query);
                $query = "select count(*) from gamenames where name = '{$gamename}'";
                $res = mysqli_query($conn, $query)->fetch_all()[0][0];
                $gamename .= "{$res}";
                echo"These are your logins for entering the game: <br>";
                for ($i = 1; $i <= $_POST["players_number"]; $i++) {
                    echo "login{$i}: {$gamename}_{$i} <br>";
                    $query = "insert into players (login, password) values ('{$gamename}_{$i}', '{$gamename}');";
                    mysqli_query($conn, $query);
                }
                echo "Password is <strong>{$gamename}</strong>. The instructor can join the game via login <strong>{$gamename}_admin</strong>.";
                $query = "insert into players (login, password) values ('{$gamename}_admin', '{$gamename}');";
                mysqli_query($conn, $query);
            }
        ?>
    </div>
</body>
</html>