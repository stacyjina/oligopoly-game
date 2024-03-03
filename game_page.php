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
</head>
<body>
    <?php 
        include("navbar.php");
    ?>

    <?php
        if (isset($_POST["start"])) {
            echo "There will be game";
        } else {
            echo "Game rules: ................... <br> Press a button below if you are ready to start.";
        }
    ?>
    <form class="start" method="POST" action="game_page.php"> 
        <button type="submit" name="start"> Start a game </button>
    </form>
</body>
</html>