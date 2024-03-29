<?php 
    require_once("db.php");
    session_start();
    include("game.php");
    $login = $_SESSION["login"];
    $gamename = $_SESSION["gamename"];
    $round = $_SESSION["round"];
    $game = new Game();
    $game->load_game($conn, $login, $gamename, $round);
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
        if (isset($_POST["start"]) or isset($_POST["move"])) {
            echo "There will be game <br>";
            echo "Demand function of an aggregated consumer:";
            $price = $game->max_price * $game->num_players;
            echo "$$ p = {$price} - \\Sigma_{i = 1}^n y_i $$";
            echo "Your firm's profit function:";
            echo "$$ \\pi = (p + 0,2 r \\cdot p) \\cdot y - 20y - 100r $$";
            // $game->save_choice(20, 60);
            if ($round != 1) {
                $table_html = "<table>";
                $table_html .= "<colgroup> 
                                    <col span='4'> 
                                    <col style='border: 2px solid black'> 
                                </colgroup>";
                $table_html .= "<tr>";
                $table_html .= "<th> Player </th> <th> Yield (Y) </th> <th> PR (R) </th> <th> Price (P) </th> <th> Profit </th>";
                $table_html .= "</tr>";
                $res = $game->get_round_results();
                foreach ($res as $id => $list) {
                    $table_html .= "<tr> <td> Player {$id} </td>";
                    $table_html .= "<td> {$list["y"]} </td> <td> {$list["r"]} </td>";
                    $table_html .= "<td> {$list["p"]} </td> <td> {$list["profit"]} </td> </tr>";
                }
                $table_html .= "</table>";
                // здесь потом будет цикл наверн
                echo $table_html;
            }
            if (isset($_POST["move"])) {
                echo "Your choice: Y = {$_POST["yield"]}, PR = {$_POST["pr"]}";
            } else {
            $sliders = "<form class='sliders' method='post' action='game_page.php'>";
            $sliders .= "<div class='sliders'> 
                            <input type='range' min='0' max='{$game->max_price}' value='0' name='yield'>
                            <input type='range' min='0' max='{$game->max_price}' value='0' name='pr'>
                        </div>";
            $sliders .= "<button type='submit' name='move'> Save choice </button>";
            $sliders .= "</form>";
            echo $sliders;
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