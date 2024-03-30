<?php 
    require_once("../db.php");
    session_start();
    include("../game.php");
    $login = $_SESSION["login"];
    $gamename = $_SESSION["gamename"];
    $round = $_SESSION["round"];
    $y = $_POST["yield"];
    $pr = $_POST["pr"];
    $game = new Game();
    $game->load_game($conn, $login, $gamename, $round);
    $game->save_choice($y, $pr);
    $flag = False;
    while (!$flag) {
        $flag = $game->check();
    }
    $game->new_round();
    $game->save_game();
    echo "Your choice was saved successfully!!!!!!!!!!";