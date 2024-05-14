<?php 
    // Database connection file
    require_once("db.php");

    // Starting a session to keep track of users
    session_start();

    // Game class file
    include("game.php");

    if (isset($_SESSION["login"])) {
        $login = $_SESSION["login"];
        $gamename = $_SESSION["gamename"];
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

    <h2> About this project </h2>

    <div class='about'> 
        <p> 
            This is a course project aimed at creating a web-app with an economic game using both front- and back-end technologies. 
            Source code can be found <a href='https://github.com/stacyjina/oligopoly-game'> here</a>.
        </p>
    </div>
    
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="js/action.js"></script>

</body>
</html>