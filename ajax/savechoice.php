<?php 
    // Database connection file
    require_once("../db.php");

    // Starting a session to keep track of users
    session_start();

    // Game class file
    include("../game.php");
    $login = $_SESSION["login"];
    $gamename = $_SESSION["gamename"];
    $y = $_POST["yield"];
    $pr = $_POST["pr"];

    // Creating a game and loading it from database
    $game = new Game();
    $game->load_game($conn, $login, $gamename);

    // Saving player's choice and waiting for other players
    $game->save_choice($y, $pr);
    $flag = False;
    while (!$flag) {
        $flag = $game->check();
    }
    $game->new_round();
    $game->save_game();
