<?php
class Database {
    private $host = "localhost";
    private $db_name = "inventaire";
    private $username = "root";
    private $password = "";

    // private $host = "145.14.153.151";
    // private $db_name = "u801021231_inventaire";
    // private $username = "u801021231_inventaire";
    // private $password = "Rootnws21";
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Erreur de connexion : " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
