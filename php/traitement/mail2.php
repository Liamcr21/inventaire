<?php

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $empruntId = $_GET["id"];

    require_once '../model/emprunt.php';
    require_once '../model/db.php';

    $database = new Database();
    $db = $database->getConnection();
    $emprunt = new Emprunt($db);
    $emprunt->id = $empruntId;
    $emprunt->readOne();

    if ($emprunt->user_id) {
        $userQuery = "SELECT nom, email FROM users WHERE id = :user_id";
        $userStmt = $db->prepare($userQuery);
        $userStmt->bindParam(":user_id", $emprunt->user_id);
        $userStmt->execute();
        $userRow = $userStmt->fetch(PDO::FETCH_ASSOC);

        $nomUtilisateur = isset($userRow['nom']) ? $userRow['nom'] : "Utilisateur inconnu";
        $to = isset($userRow['email']) ? $userRow['email'] : "cariou.liam@orange.fr";
    } else {
        $nomUtilisateur = "Utilisateur inconnu";
        $to = "cariou.liam@orange.fr";
    }

    if ($emprunt->materiel_id) {
        $materielQuery = "SELECT nom FROM materiels WHERE id = :materiel_id";
        $materielStmt = $db->prepare($materielQuery);
        $materielStmt->bindParam(":materiel_id", $emprunt->materiel_id);
        $materielStmt->execute();
        $materielRow = $materielStmt->fetch(PDO::FETCH_ASSOC);
        $nomMateriel = isset($materielRow['nom']) ? $materielRow['nom'] : "Matériel inconnu";
    } else {
        $nomMateriel = "Matériel inconnu";
    }

    $message = "Bonjour $nomUtilisateur,\n\n";
    $message .= "Confirmation emprunt en cours avec les détails suivants :\n\n";
    $message .= "Nom du matériel: $nomMateriel\n";
    $message .= "Date de début: {$emprunt->date_debut}\n";
    $message .= "Date de fin: {$emprunt->date_fin}\n\n";
    $message .= "Cordialement,\nNWS";

    $subject = "Confirmation emprunt en cours";
    $headers = "From: inventaire@nws.fr"; 

    if (mail($to, $subject, $message, $headers)) {
        echo "E-mail envoyé avec succès.";
        header("Location: ../../pret/list.php");
        exit();
    } else {
        echo "Erreur lors de l'envoi de l'e-mail.";
        header("Location: ../../pret/list.php");
        exit();
    }
} else {
    echo "Erreur : ID d'emprunt non spécifié.";
    header("Location: ../../pret/list.php");
    exit();
}
?>
