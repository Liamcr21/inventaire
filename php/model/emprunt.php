<?php
class Emprunt {
    private $conn;
    private $table_name = "empreints";

    public $id;
    public $user_id;
    public $materiel_id;
    public $date_debut;
    public $date_fin;
    public $quantite;

    public function __construct($db) {
        $this->conn = $db;
    }

function createAndUpdateMateriel() {
    try {
        $this->conn->beginTransaction();

        if ($this->isMaterielAvailable()) {
            $query = "INSERT INTO " . $this->table_name . " SET user_id=:user_id, materiel_id=:materiel_id, date_debut=:date_debut, date_fin=:date_fin";
            $stmt = $this->conn->prepare($query);

            $this->user_id = htmlspecialchars(strip_tags($this->user_id));
            $this->materiel_id = htmlspecialchars(strip_tags($this->materiel_id));
            $this->date_debut = htmlspecialchars(strip_tags($this->date_debut));
            $this->date_fin = htmlspecialchars(strip_tags($this->date_fin));

            $stmt->bindParam(":user_id", $this->user_id);
            $stmt->bindParam(":materiel_id", $this->materiel_id);
            $stmt->bindParam(":date_debut", $this->date_debut);
            $stmt->bindParam(":date_fin", $this->date_fin);

            if (!$stmt->execute()) {
                $this->conn->rollBack();
                return false;
            }

            if (!$this->updateMaterielQuantity(-1)) {
                $this->conn->rollBack();
                return false;
            }

            $this->sendConfirmationEmail();

            $this->conn->commit();
            return true;
        } else {
            echo "La quantité disponible du matériel est épuisée. Impossible de créer l'emprunt.";
            $this->conn->rollBack();
            return false;
        }
    } catch (PDOException $e) {
        $this->conn->rollBack();
        echo "Erreur de transaction : " . $e->getMessage();
        return false;
    }
}

private function isMaterielAvailable() {
    $query = "SELECT quantite_disponible FROM materiels WHERE id = :materiel_id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":materiel_id", $this->materiel_id);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return isset($row['quantite_disponible']) && $row['quantite_disponible'] > 0;
}


private function sendConfirmationEmail() {
    $userEmailQuery = "SELECT email FROM users WHERE id = :user_id";
    $userEmailStmt = $this->conn->prepare($userEmailQuery);
    $userEmailStmt->bindParam(":user_id", $this->user_id);
    $userEmailStmt->execute();
    $userEmailRow = $userEmailStmt->fetch(PDO::FETCH_ASSOC);
    $userEmail = isset($userEmailRow['email']) ? $userEmailRow['email'] : "";

    if (!empty($userEmail)) {
        $subject = "Confirmation d'emprunt";
        $message = "Votre emprunt a été confirmé. Détails de l'emprunt:\n";
        $message .= "Matériel ID: {$this->materiel_id}\n";
        $message .= "Date de début: {$this->date_debut}\n";
        $message .= "Date de fin: {$this->date_fin}\n";

        mail($userEmail, $subject, $message);
    }
}


    private function updateMaterielQuantity($increment) {
        $query = "UPDATE materiels SET quantite_disponible = quantite_disponible + :increment WHERE id = :materiel_id";

        $stmt = $this->conn->prepare($query);

        $this->materiel_id = htmlspecialchars(strip_tags($this->materiel_id));
        $increment = htmlspecialchars(strip_tags($increment));

        $stmt->bindParam(":materiel_id", $this->materiel_id);
        $stmt->bindParam(":increment", $increment);

        $stmt->execute();
    }

    function read() {
        $query = "SELECT id, user_id, materiel_id, date_debut, date_fin FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }


function delete() {
    $this->readOne();  

    $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->id);

    if ($stmt->execute()) {
        $currentQuantity = $this->getCurrentMaterielQuantity();

        $this->updateMaterielQuantity($currentQuantity + 1);

        return true;
    }

    return false;
}

private function getCurrentMaterielQuantity() {
    $query = "SELECT materiel_id FROM " . $this->table_name . " WHERE id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->id);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

}

function readOne() {
    $query = "SELECT id, user_id, materiel_id, date_debut, date_fin FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->id);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $this->user_id = $row['user_id'];
    $this->materiel_id = $row['materiel_id'];
    $this->date_debut = $row['date_debut'];
    $this->date_fin = $row['date_fin'];
}

function update() {
    $query = "UPDATE " . $this->table_name . " SET user_id=:user_id, materiel_id=:materiel_id, date_debut=:date_debut, date_fin=:date_fin WHERE id = :id";

    $stmt = $this->conn->prepare($query);

    $this->user_id = htmlspecialchars(strip_tags($this->user_id));
    $this->materiel_id = htmlspecialchars(strip_tags($this->materiel_id));
    $this->date_debut = htmlspecialchars(strip_tags($this->date_debut));
    $this->date_fin = htmlspecialchars(strip_tags($this->date_fin));
    $this->id = htmlspecialchars(strip_tags($this->id));

    $stmt->bindParam(":user_id", $this->user_id);
    $stmt->bindParam(":materiel_id", $this->materiel_id);
    $stmt->bindParam(":date_debut", $this->date_debut);
    $stmt->bindParam(":date_fin", $this->date_fin);
    $stmt->bindParam(":id", $this->id);

    if ($stmt->execute()) {
        return true;
    }

    return false;
}

function readUserEmprunts() {
    $query = "SELECT materiel_id, date_debut, date_fin FROM " . $this->table_name . " WHERE user_id = :user_id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":user_id", $this->user_id);
    $stmt->execute();

    return $stmt;
}

}
?>
