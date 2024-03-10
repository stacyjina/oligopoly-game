<?php
    include("db.php");

    function save_choice($conn, $gamename, $username, $round, $y, $r) {
        $query = "insert into moves (game, login, round, yield, pr) 
                values ('{$gamename}', '{$username}', {$round}, {$y}, {$r})";
        mysqli_query($conn, $query);
    }

    function get_round_results($conn, $gamename, $round) {
        $query = "select login, yield, pr from moves where game = '{$gamename}' and round = {$round}";
        $res = mysqli_query($conn, $query)->fetch_all(MYSQLI_ASSOC);
        $list = [];
        $y = 0;
        foreach ($res as $row) {
            $list[substr($row["login"], -1, 1)] = ["yield" => $row["yield"], "pr" => $row["pr"]];
            $y += $row["yield"];
        }
        $p = 100 - $y;
        echo "y = {$y}, p = {$p} <br>";
        foreach ($list as $key => $value) {
            echo $key;
            echo "<br>";
            foreach ($value as $k => $val) {
                echo "{$k} => {$val} <br>";
            }
        }
    }