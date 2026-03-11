<?php

class Dbh {

    // Attributes
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db = "foimsdb";
    private $conn;

    // Methods for connection
    protected function connection(){

        // Only create PDO once
        if (!$this->conn) {
            try {
                $dsn = 'mysql:host='. $this->host . ';dbname=' . $this->db;
                $this->conn = new PDO($dsn, $this->user, $this->pass);
                $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // good practice
            } catch(PDOException $e) {
                echo "Error:" . $e->getMessage() . "<br>";
                die();
            }
        }
        return $this->conn;
    }
}