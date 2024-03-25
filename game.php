<?php
    include("db.php");

    class Game {

        private $conn;
        private $cur_round;
        private $login;
        private $gamename;
        public $num_players = 5;
        public $max_price = 50;
        private $costs = 20;

        function load_game($conn, $login, $gamename, $round) {
            $this->conn = $conn;
            $this->login = $login;
            $this->gamename = $gamename;
            $this->cur_round = $round;
        }

        function save_choice($y, $r) {
            $query = "insert into moves (game, login, round, yield, pr) 
                    values ('{$this->gamename}', '{$this->login}', {$this->cur_round}, {$y}, {$r})";
            mysqli_query($this->conn, $query);
        }

        function get_round_results() {
            $query = "select login, yield, pr from moves where game = '{$this->gamename}' and round = {$this->cur_round}";
            $res = mysqli_query($this->conn, $query)->fetch_all(MYSQLI_ASSOC);
            $list = [];
            $y = 0;
            foreach ($res as $row) {
                $list[substr($row["login"], -1, 1)] = ["yield" => $row["yield"], "pr" => $row["pr"]];
                $y += $row["yield"];
            }
            $p = $this->max_price * $this->num_players - $y;
            echo "y = {$y}, p = {$p} <br>";
            $res = [];
            foreach ($list as $key => $value) {
                // echo $key;
                // echo "<br>";
                $res[$key] = ["y" => $value["yield"], 
                                "r" => $value["pr"], 
                                "p" => $p * (1 + 0.002 * $value["pr"]),
                                "profit" => $p * (1 + 0.002 * $value["pr"]) * $value["yield"] - 
                                                $this->costs * $value["yield"] - $value["pr"]
                            ];
                $query = "insert into rounds (game, login, round, profit) 
                            values ('{$this->gamename}', '{$this->login}', {$this->cur_round}, {$res[$key]["profit"]})";
                // mysqli_query($this->conn, $query);
                // foreach ($res[$key] as $k => $val) {
                //     echo "{$k} => {$val} <br>";
                // }
            }
            return $res;
        }

        function get_final_results() {

        }
    }

    // function save_choice($conn, $gamename, $username, $round, $y, $r) {
    //     $query = "insert into moves (game, login, round, yield, pr) 
    //             values ('{$gamename}', '{$username}', {$round}, {$y}, {$r})";
    //     mysqli_query($conn, $query);
    // }

    // function get_round_results($conn, $gamename, $round) {
    //     $query = "select login, yield, pr from moves where game = '{$gamename}' and round = {$round}";
    //     $res = mysqli_query($conn, $query)->fetch_all(MYSQLI_ASSOC);
    //     $list = [];
    //     $y = 0;
    //     foreach ($res as $row) {
    //         $list[substr($row["login"], -1, 1)] = ["yield" => $row["yield"], "pr" => $row["pr"]];
    //         $y += $row["yield"];
    //     }
    //     $p = 100 - $y;
    //     echo "y = {$y}, p = {$p} <br>";
    //     foreach ($list as $key => $value) {
    //         echo $key;
    //         echo "<br>";
    //         foreach ($value as $k => $val) {
    //             echo "{$k} => {$val} <br>";
    //         }
    //     }
    // }