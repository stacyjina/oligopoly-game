<?php 
    // Database connection file
    require_once("db.php");

    // Starting a session to keep track of users
    session_start();

    // Game class file
    include("game.php");
    $login = $_SESSION["login"];
    $gamename = $_SESSION["gamename"];

    // Creating a game and loading it from database
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

    <!-- Navigation bar -->

    <?php 
        include("navbar.php");
    ?>

    <?php
        // Check if the game is in progress
        if (isset($_SESSION["start"]) and $game->cur_round <= $game->last_round) {
            echo "<div class='main'><h2> Round {$game->cur_round} </h2>";
            echo "Demand function of an aggregated consumer:";
            $price = $game->max_price * $game->num_players;
            echo "$$ p = {$price} - \\Sigma_{i = 1}^{$game->num_players} y_i $$";
            echo "Your firm's profit function:";
            echo "$$ \\pi = p \\cdot y - 0.5y^2 - 10y - 0.15r^2 + r \\sqrt{y}$$";

            // If it is not the 1st round, show last round's results
            if ($game->cur_round != 1) {
                $table_html = "<table>";
                $table_html .= "<colgroup> 
                                    <col span='4'>
                                </colgroup>";
                $table_html .= "<tr>";
                $table_html .= "<th> Player </th> <th> Yield (Y) </th> <th> PR (R) </th> <th> Price (P) </th> <th> Profit </th>";
                $table_html .= "</tr>";
                $res = $game->get_round_results();
                foreach ($res as $id => $list) {
                    $bgcolor = "";
                    if ($id == substr($login, -1, 1)) {
                        $bgcolor = "style='background-color: #AAD7D9'";
                    }
                    $table_html .= "<tr {$bgcolor}> <td> Player {$id} </td>";
                    $table_html .= "<td> {$list["y"]} </td> <td> {$list["r"]} </td>";
                    $table_html .= "<td> {$list["p"]} </td> <td> {$list["profit"]} </td> </tr>";
                }
                $table_html .= "</table>";
                echo $table_html;
            }

            // Main sliders of the game
            echo "<div id='choice'>";
            $sliders = "<form class='sliders'></div>";
            $sliders .= "<div class='sliders'> 
                            Yeild (y)
                            <br>
                            <input type='range' min='0' max='{$game->max_price}' value='0' name='yield' id='yield'
                                oninput='this.nextElementSibling.value = this.value'>
                            <output>0</output>
                        </div>
                        <div class='sliders'> 
                            Marketing (r)
                            <br>
                            <input type='range' min='0' max='{$game->max_price}' value='0' name='pr' id='pr'
                                oninput='this.nextElementSibling.value = this.value'>
                            <output>0</output>
                        </div> <br>";
            $sliders .= "<button type='submit' name='move' id='move'> Save choice </button>";
            $sliders .= "</form>";
            echo $sliders;

            // Helper that gives recommendations 
            $max_y = ($game->num_players - 1) * $game->max_price;
            $helper = "<p> If you are not sure what choice to make, fell free to use this recommedation system. <br>
                        Use the slider below to enter expected aggregated yield of other players. </p>";
            $helper .= "<div id='helper'></div>";
            $helper .= "<form class='helper'>
                            Total yield of other players
                            <br>
                            <input type='range' min='0' max='{$max_y}' value='0' name='agg_yield' id='agg_yield'
                                oninput='this.nextElementSibling.value = this.value'>
                            <output>0</output>";
            $helper .= "<br><button type='button' name='move_help' id='move_help'> See recommendations </button>";
            $helper .= "</form>";
            echo $helper;
            echo "</div>";
        } else if ($game->cur_round <= $game->last_round) { 
            // If the game hasn't started yet, show rules
            echo "<div class='main'><h2>Game rules</h2>";
            $rules = "<p>Imagine that you and other players are firms selling the same good to an aggregated consumer. <br>
                There will be 5 rounds. In each round you are supposed to choose how many pieces of good your firm will be producing (y)
                and how much money you will be spending on marketing (r). Your goal is to maximise firm's profit. 
                After each round you will be able to see choices and profits of other players. Also, if you struggling to make your choice, 
                there will be an interface that can give some useful recommendations. </p> 
                <h3> Press a button below if you are ready to start. </h3> </div>";
            echo $rules;
            echo '<form class="start" method="POST" action="game_page.php"> 
                <button type="submit" name="start"> Start a game </button>
                </form>';
        } else {
            // If the game is over, showing final result of the game
            $res = $game->get_final_results();
            $table_html = "<h2> Final Results </h2> <div class='main'> 
                            <h3> Congratulations! </h3> <table>";
            $table_html .= "<tr>";
            $table_html .= "<th> Player </th> <th> Profit </th>";
            $table_html .= "</tr>";
            foreach ($res as $id => $profit) {
                $bgcolor = "";
                if ($id == substr($login, -1, 1)) {
                    $bgcolor = "style='background-color: #AAD7D9'";
                }
                $table_html .= "<tr {$bgcolor}> <td> Player {$id} </td>";
                $table_html .= "<td> {$profit} </td>";
            }
            $table_html .= "</table>";
            $table_html .= "<h3> Result of the last round </h3> <table>";
            $table_html .= "<colgroup> 
                                <col span='4'>
                            </colgroup>";
            $table_html .= "<tr>";
            $table_html .= "<th> Player </th> <th> Yield (Y) </th> <th> PR (R) </th> <th> Price (P) </th> <th> Profit </th>";
            $table_html .= "</tr>";
            $res = $game->get_round_results();
            foreach ($res as $id => $list) {
                $bgcolor = "";
                if ($id == substr($login, -1, 1)) {
                    $bgcolor = "style='background-color: #AAD7D9'";
                }
                $table_html .= "<tr {$bgcolor}> <td> Player {$id} </td>";
                $table_html .= "<td> {$list["y"]} </td> <td> {$list["r"]} </td>";
                $table_html .= "<td> {$list["p"]} </td> <td> {$list["profit"]} </td> </tr>";
            }
            $table_html .= "</table> </div>";
            echo $table_html;
        }
    ?>

    <!-- Scripts for jquery, ajax -->

    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="js/action.js"></script>

</body>
</html>