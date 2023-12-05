<?php 
error_reporting(E_ERROR | E_PARSE);

?>
<?php
require_once '../php/model/emprunt.php';

require_once '../php/model/db.php';

$database = new Database();
$db = $database->getConnection();

$emprunt = new Emprunt($db);

if (isset($_GET['id'])) {
    $emprunt->id = $_GET['id'];

    // Supprimer l'emprunt
    if ($emprunt->delete()) {
        echo "L'emprunt a été supprimé avec succès.";
        header("Location: list.php");
        exit();
    } else {
        echo "Erreur lors de la suppression de l'emprunt.";
        header("Location: list.php");
        exit();
    }
} else {
    echo "ID de l'emprunt non spécifié.";
}
?>
