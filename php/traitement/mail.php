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
    

 $to = 'cariou.liam@orange.fr';

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

    $message = "Bonjour {$userDetails['nom']},\n\n";
    $message .= "Vous avez un emprunt en cours avec les détails suivants :\n\n";
    $message .= "Nom du matériel: $nomMateriel\n";
    $message .= "Date de début: {$emprunt->date_debut}\n";
    $message .= "Date de fin: {$emprunt->date_fin}\n\n";
    $message .= "Cordialement,\nNWS";

    $subject = "Détails de l'emprunt en cours";
    $headers = "From: inventaire@nws.fr"; 

    if (mail($to, $subject, $message, $headers)) {
        echo "E-mail envoyé avec succès.";

    } else {
        echo "Erreur lors de l'envoi de l'e-mail.";

    }
} else {
    echo "Erreur : ID d'emprunt non spécifié.";

}
?>
