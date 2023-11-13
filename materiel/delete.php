

<?php
include_once '../php/model/db.php';
include_once '../php/model/materiel.php';

$database = new Database();
$db = $database->getConnection();
$materiel = new Materiel($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $materiel->id = $_POST["id"];

    if ($materiel->delete()) {
        header("Location:list.php");
        exit();
    } else {
        header("HTTP/1.1 500 Internal Server Error");
        echo "Erreur lors de la suppression du matériel.";
    }
} else {
    echo "Méthode de requête non autorisée.";
}
?>
