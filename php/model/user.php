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

    // Fonction pour récupérer tous les utilisateurs
    function read() {
        $query = "SELECT id, nom,email, role FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Fonction pour récupérer un seul utilisateur par ID
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

    // Fonction pour mettre à jour un utilisateur
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

    // Fonction pour supprimer un utilisateur
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
