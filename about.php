<?php 
    require_once("db.php");
    session_start();
    include("game.php");
    $login = $_SESSION["login"];
    $gamename = $_SESSION["gamename"];
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

    <h2> About this project </h2>

    <div class='about'> 
        <p> 
            This is a course project aimed at creating a web-app with an economic game using both front- and back-end technologies. 
            Source code can be found <a href='https://github.com/stacyjina/oligopoly-game'> here</a>.
        </p>
    </div>
    
</body>
</html>