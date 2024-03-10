<?php 
    require_once("db.php");
    session_start();
    include("game.php");
    $login = $_SESSION["login"];
    $gamename = $_SESSION["gamename"];
    $round = $_SESSION["round"];
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
            echo "There will be game <br>";
            echo "Demand function of an aggregated consumer:";
            echo "$$ p = 100 - \\Sigma_{i = 1}^n y_i $$";
            echo "Your firm's profit function:";
            echo "$$ \\pi = (p + 0,2 r \\cdot p) \\cdot y - 10y - 100r $$";
            get_round_results($conn, $gamename, 1);
            if ($round != 1) {
                $table_html = "<table>";
                $table_html .= "<tr>";
                $table_html .= "<th> Player </th> <th> Yield (Y) </th> <th> PR (R) </th> <th> Price (P) </th> <th> Profit </th>";
                $table_html .= "</tr>";
                // здесь потом будет цикл наверн
                echo $table_html;
            }
        } else {
            echo "Game rules: ................... <br> Press a button below if you are ready to start.<br>";
            echo '<form class="start" method="POST" action="game_page.php"> 
                <button type="submit" name="start"> Start a game </button>
                </form>';
        }
    ?>
    <!-- <form class="start" method="POST" action="game_page.php"> 
        <button type="submit" name="start"> Start a game </button>
    </form> -->

    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>

</body>
</html>