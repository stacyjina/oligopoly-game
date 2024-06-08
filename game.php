<?php
    include("db.php");

    class Game {

        private $conn; // DB connection
        public $cur_round; // number of current round
        private $login; // login of a player
        private $gamename; // name of the game
        public $num_players = 2; // number of players in a game
        public $max_price = 50;
        private $costs = 20; // marginal costs of a firm
        public $last_round = 5; // number of rounds in a game

        function load_game($conn, $login, $gamename) {
            // Loads a game from database
            $this->conn = $conn;
            $this->login = $login;
            $this->gamename = $gamename;
            $query = "select cur_round, num_players from games where gamename = '{$gamename}'";
            $res = mysqli_query($this->conn, $query)->fetch_all(MYSQLI_ASSOC)[0];
            $this->cur_round = $res["cur_round"];
            $this->num_players = $res["num_players"];
        }

        function save_choice($y, $r) {
            // Saves player's choice to database
            $query = "insert into moves (game, login, round, yield, pr) 
                    values ('{$this->gamename}', '{$this->login}', {$this->cur_round}, {$y}, {$r})";
            mysqli_query($this->conn, $query);
        }

        function get_round_results() {
            // Loads results of the last played round
            $round = $this->cur_round - 1;
            $query = "select login, yield, pr from moves where game = '{$this->gamename}' and round = {$round} order by login asc";
            $res = mysqli_query($this->conn, $query)->fetch_all(MYSQLI_ASSOC);
            $list = [];
            $y = 0;
            foreach ($res as $row) {
                $list[substr($row["login"], -1, 1)] = ["yield" => $row["yield"], "pr" => $row["pr"]];
                $y += $row["yield"];
            }
            $p = $this->max_price * $this->num_players - $y;
            $res = [];
            foreach ($list as $key => $value) {
                $res[$key] = ["y" => $value["yield"], 
                                "r" => $value["pr"], 
                                "p" => $p,
                                "profit" => round($p * $value["yield"] - 10 * $value["yield"] - 0.5 * $value["yield"] * $value["yield"]
                                                - 0.15 * $value["pr"] * $value["pr"] + $value["pr"] * sqrt($value["yield"]), 2)
                            ];
                if ($key == substr($this->login, -1, 1)) {
                    $query = "insert into rounds (game, login, round, profit) 
                            values ('{$this->gamename}', '{$this->login}', {$this->cur_round}, {$res[$key]["profit"]})";
                    mysqli_query($this->conn, $query);
                }
            }
            return $res;
        }

        function check() {
            // Check whether all players made their choices
            $query = "select count(*) from moves where game = '{$this->gamename}' and round = {$this->cur_round}";
            $res = mysqli_query($this->conn, $query)->fetch_all()[0][0];
            if ($res == $this->num_players) {
                return True;
            }
            return False;
        }

        function new_round() {
            // Starts new round
            $this->cur_round += 1;
        }

        function save_game() {
            // Saves game to database
            $query = "update games set cur_round = {$this->cur_round} where gamename = '{$this->gamename}'";
            mysqli_query($this->conn, $query);
        }

        function get_final_results() {
            // Loads final result of the game
            $query = "select login, sum(profit) as profit from rounds where game = '{$this->gamename}' group by 1 order by login asc";
            $res = mysqli_query($this->conn, $query)->fetch_all(MYSQLI_ASSOC);
            $list = [];
            foreach ($res as $row) {
                $list[substr($row["login"], -1, 1)] = round($row["profit"], 2);
            }
            return $list;
        }
    }
