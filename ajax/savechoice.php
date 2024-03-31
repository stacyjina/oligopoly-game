<?php 
    require_once("../db.php");
    session_start();
    include("../game.php");
    $login = $_SESSION["login"];
    $gamename = $_SESSION["gamename"];
    $y = $_POST["yield"];
    $pr = $_POST["pr"];
    $game = new Game();
    $game->load_game($conn, $login, $gamename);
    $game->save_choice($y, $pr);
    $flag = False;
    while (!$flag) {
        $flag = $game->check();
    }
    $game->new_round();
    $game->save_game();
