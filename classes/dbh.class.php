<?php

    class Dbh {
        private $host   = "localhost";
        private $user   = "root";
        private $pass   = ""; 
        private $dbname = "gnote";

        protected function connect() {
            try{
                $dsn    = "mysql:host=".$this->host.";dbname=".$this->dbname;
                $connection = new PDO($dsn, $this->user, $this->pass);
                return $connection;    
            }catch (PDOException $e){
                echo $e->getMessage();
            }
        }
    }

?>