<?php
include_once '../model/db.php';
include_once '../model/materiel.php';

$database = new Database();
$db = $database->getConnection();
$materiel = new Materiel($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $materiel->id = $_POST["modifier_id"];
    $materiel->nom = $_POST["modifier_nom"];
    $materiel->quantite_disponible = $_POST["modifier_quantite_disponible"];

    if ($materiel->update()) {
        header("Location: ../../materiel/list.php");
        exit();
    } else {
        echo "Erreur lors de la modification du matériel.";
    }
}
?>
