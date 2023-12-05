<?php
require_once '../php/model/emprunt.php';

require_once '../php/model/db.php';

$database = new Database();
$db = $database->getConnection();

$emprunt = new Emprunt($db);

if (isset($_GET['id'])) {
    $emprunt->id = $_GET['id'];
} else {
    header("Location: erreur.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emprunt->user_id = $_POST['user_id'];
    $emprunt->materiel_id = $_POST['materiel_id'];
    $emprunt->date_debut = $_POST['date_debut'];
    $emprunt->date_fin = $_POST['date_fin'];

    if ($emprunt->update()) {
        echo "L'emprunt a été mis à jour avec succès.";
    } else {
        echo "Erreur lors de la mise à jour de l'emprunt.";
    }
}

$emprunt->readOne();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mise à jour de l'emprunt</title>
</head>
<body>

    <h2>Mise à jour de l'emprunt</h2>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$emprunt->id}"); ?>">
        <label for="user_id">ID Utilisateur:</label>
        <input type="text" name="user_id" value="<?php echo $emprunt->user_id; ?>" required><br>

        <label for="materiel_id">ID Matériel:</label>
        <input type="text" name="materiel_id" value="<?php echo $emprunt->materiel_id; ?>" required><br>

        <label for="date_debut">Date de début:</label>
        <input type="text" name="date_debut" value="<?php echo $emprunt->date_debut; ?>" required><br>

        <label for="date_fin">Date de fin:</label>
        <input type="text" name="date_fin" value="<?php echo $emprunt->date_fin; ?>" required><br>

        <input type="submit" value="Mettre à jour">
    </form>

    <p><a href="liste_emprunts.php">Retour à la liste des emprunts</a></p>

</body>
</html>
