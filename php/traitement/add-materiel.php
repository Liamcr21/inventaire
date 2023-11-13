<?php
include_once '../model/db.php';
include_once '../model/materiel.php';

$database = new Database();
$db = $database->getConnection();

$materiel = new Materiel($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $materiel->nom = $_POST["nom"];
    $materiel->quantite_disponible = $_POST["quantite_disponible"];

    if ($materiel->create()) {
        echo "Matériel ajouté avec succès.";
    } else {
        echo "Erreur lors de l'ajout du matériel.";
    }
}
?>
