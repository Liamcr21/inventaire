<?php
class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $nom;
    public $role;
    public $email;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Fonction pour créer un nouvel utilisateur
    function create() {
        $query = "INSERT INTO " . $this->table_name . " SET nom=:nom,email=:email, role=:role";

        $stmt = $this->conn->prepare($query);

        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->role = htmlspecialchars(strip_tags($this->role));


        $stmt->bindParam(":nom", $this->nom);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":role", $this->role);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

public function read() {
        $query = "SELECT student_id FROM student_ids";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $studentIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

        if (!empty($studentIds)) {
            $apiUrl = "http://vps-a47222b1.vps.ovh.net:4242/student?ids=" . implode(',', $studentIds);

            $apiResponse = file_get_contents($apiUrl);
            $students = json_decode($apiResponse, true);

            return $students ?: [];
        } else {
            return [];
        }
    }



    function readOne() {
        $query = "SELECT id, nom,email, role FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->nom = $row['nom'];
        $this->email = $row['email'];
        $this->role = $row['role'];
    }

    function update() {
        $query = "UPDATE " . $this->table_name . " SET nom=:nom,email=:email, role=:role WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->role = htmlspecialchars(strip_tags($this->role));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":nom", $this->nom);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":role", $this->role);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function getUserNameById($user_id) {
        $query = "SELECT nom FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $user_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['nom'];
    }

}
?>
