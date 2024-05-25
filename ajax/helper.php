<?php
    // Database connection file
    require_once("../db.php");

    // Starting a session to keep track of users
    session_start();

    // Game class file
    include("../game.php");
    $login = $_SESSION["login"];
    $gamename = $_SESSION["gamename"];
    $s = $_POST["yield"];

    // Creating a game and loading it from database
    $game = new Game();
    $game->load_game($conn, $login, $gamename);

    // Calculate the best solution for given y
    $n = $game->num_players;
    $y = intval((50 * $n - $s - 9)/3);
    $r = intval(sqrt((50 * $n - $s - 9)/3)/0.3);
    $y = min($y, $game->max_price);
    $r = min($r, 100);
    echo strval($y) . " " . strval($r);