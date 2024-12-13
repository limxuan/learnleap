<?php
// db_config.php

class Database {
    private static $conn = null;

    // Prevent the class from being instantiated directly
    private function __construct() {}

    public static function getConnection() {
        if (self::$conn === null) {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "testdb";
            
            try {
                self::$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }
        }
        
        return self::$conn;
    }
}
?>
