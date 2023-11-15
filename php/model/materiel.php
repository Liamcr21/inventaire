<?php
class Materiel {
    private $conn;
    private $table_name = "materiels";

    public $id;
    public $nom;
    public $quantite_disponible;
    public $quantite;

    public function __construct($db) {
        $this->conn = $db;
    }

    function updateQuantity() {
        $query = "UPDATE materiels SET quantite_disponible = :quantite_disponible WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->quantite = htmlspecialchars(strip_tags($this->quantite));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":quantite_disponible", $this->quantite);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function create() {
        $query = "INSERT INTO " . $this->table_name . " SET nom=:nom, quantite_disponible=:quantite_disponible";

        $stmt = $this->conn->prepare($query);

        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->quantite_disponible = htmlspecialchars(strip_tags($this->quantite_disponible));

        $stmt->bindParam(":nom", $this->nom);
        $stmt->bindParam(":quantite_disponible", $this->quantite_disponible);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function read() {
        $query = "SELECT id, nom, quantite_disponible FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    function readOne() {
        $query = "SELECT id, nom, quantite_disponible FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->nom = $row['nom'];
        $this->quantite_disponible = $row['quantite_disponible'];
    }

    function update() {
        $query = "UPDATE " . $this->table_name . "
                  SET nom = :nom, quantite_disponible = :quantite_disponible
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Liaison des valeurs
        $stmt->bindParam(":nom", $this->nom);
        $stmt->bindParam(":quantite_disponible", $this->quantite_disponible);
        $stmt->bindParam(":id", $this->id);

        // Exécution de la requête
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

    function getNombrePretsEnCours($materielId) {
        $query = "SELECT COUNT(*) as nombre_prets FROM empreints WHERE materiel_id = :materiel_id AND CURRENT_DATE BETWEEN date_debut AND date_fin";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":materiel_id", $materielId);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return isset($row['nombre_prets']) ? $row['nombre_prets'] : 0;
    }
    
    function getMaterielNameById($materiel_id) {
        $query = "SELECT nom FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $materiel_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['nom'];
    }
}
?>
