<?php
class Database {
    private $host = "localhost";
    private $db_name = "crud_pasteles";
    private $username = "root"; // Cambiamos esto si las credendiales son diferentes
    private $password = "1234"; // Cambiamos esto si las credendiales son diferentes
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
