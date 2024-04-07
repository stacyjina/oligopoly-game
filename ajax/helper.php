<?php
    require_once("../db.php");
    session_start();
    include("../game.php");
    $login = $_SESSION["login"];
    $gamename = $_SESSION["gamename"];
    $s = $_POST["yield"];
    $game = new Game();
    $game->load_game($conn, $login, $gamename);
    $n = $game->num_players;
    $y = intval(25 * $n - $s/2 - 15/4);
    $r = intval(5/2 * sqrt(100 * $n - 2 * $s - 15));
    $y = min($y, $game->max_price);
    $r = min($r, 100);
    echo strval($y) . " " . strval($r);