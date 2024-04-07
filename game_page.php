<?php 
    require_once("db.php");
    session_start();
    include("game.php");
    $login = $_SESSION["login"];
    $gamename = $_SESSION["gamename"];
    $game = new Game();
    $game->load_game($conn, $login, $gamename);
    if (isset($_POST["start"])) {
        $_SESSION["start"] = True;
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
    <?php 
        include("navbar.php");
    ?>

    <?php
        // if (isset($_POST["start"]) or isset($_POST["move"])) {
        if (isset($_SESSION["start"]) and $game->cur_round <= $game->last_round) {
            echo "Round {$game->cur_round}";
            echo "Demand function of an aggregated consumer:";
            $price = $game->max_price * $game->num_players;
            echo "$$ p = {$price} - \\Sigma_{i = 1}^{$game->num_players} y_i $$";
            echo "Your firm's profit function:";
            echo "$$ \\pi = p \\cdot y - 20y - 0.5r^2 + r \\sqrt{y}$$";
            if ($game->cur_round != 1) {
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
                echo $table_html;
            }
            echo "<div id='choice'>";
            $sliders = "<form class='sliders'></div>";
            // method='post' action='game_page.php'
            $sliders .= "<div class='sliders'> 
                            <input type='range' min='0' max='{$game->max_price}' value='0' name='yield' id='yield'
                                oninput='this.nextElementSibling.value = this.value'>
                            <output>0</output>
                            <input type='range' min='0' max='{$game->max_price}' value='0' name='pr' id='pr'
                                oninput='this.nextElementSibling.value = this.value'>
                            <output>0</output>
                        </div>";
            $sliders .= "<button type='submit' name='move' id='move'> Save choice </button>";
            $sliders .= "</form>";
            echo $sliders;

            $max_y = ($game->num_players - 1) * $game->max_price;
            $helper = "<div id='helper'></div>";
            $helper .= "<form class='helper'>
                            <input type='range' min='0' max='{$max_y}' value='0' name='agg_yield' id='agg_yield'
                                oninput='this.nextElementSibling.value = this.value'>
                            <output>0</output>";
            $helper .= "<br><button type='button' name='move_help' id='move_help'> See recommendations </button>";
            $helper .= "</form>";
            echo $helper;    

        } else if ($game->cur_round <= $game->last_round) {
            echo "Game rules: ................... <br> Press a button below if you are ready to start.<br>";
            echo '<form class="start" method="POST" action="game_page.php"> 
                <button type="submit" name="start"> Start a game </button>
                </form>';
        } else {
            $res = $game->get_final_results();
            $table_html = "<h2> Final Results </h2><table>";
            $table_html .= "<colgroup> 
                                <col span='4'> 
                                <col style='border: 2px solid black'> 
                            </colgroup>";
            $table_html .= "<tr>";
            $table_html .= "<th> Player </th> <th> Profit </th>";
            $table_html .= "</tr>";
            foreach ($res as $id => $profit) {
                $table_html .= "<tr> <td> Player {$id} </td>";
                $table_html .= "<td> {$profit} </td>";
            }
            $table_html .= "</table>";
            echo $table_html;
        }
    ?>

    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="js/action.js"></script>

</body>
</html>