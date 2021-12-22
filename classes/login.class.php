<?php
    // require "dbh.class.php";

    class Test extends Dbh {

        public function __construct() {
            // Default Constructor 
        }

        public function getUsers($user,$pass){
            if($this->connect() !== null){
                $sql = "SELECT * FROM users WHERE username = ? AND password = ? ";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute(array($user,$pass));
                return $stmt->fetch();
            }
        }

    }

?>