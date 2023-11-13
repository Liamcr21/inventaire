

<?php
include_once '../php/model/db.php';
include_once '../php/model/user.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user->id = $_POST["id"];

    if ($user->delete()) {
        header("Location:list.php");
        exit();
    } else {
        header("HTTP/1.1 500 Internal Server Error");
        echo "Erreur lors de la suppression de l'user.";
    }
} else {
    echo "Méthode de requête non autorisée.";
}
?>
