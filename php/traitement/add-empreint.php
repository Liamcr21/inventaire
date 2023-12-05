<?php
require_once '../model/emprunt.php';
require_once '../model/user.php';
require_once '../model/materiel.php';
require_once '../model/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $materiel_id = $_POST['materiel_id'];
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];

    $emprunt_cree_avec_succes = true;

    if ($emprunt_cree_avec_succes) {
        $user = new User($db);
        $user_name = $user->getUserNameById($user_id); 

        $materiel = new Materiel($db);
        $materiel_name = $materiel->getMaterielNameById($materiel_id); 
        echo "L'emprunt a été créé avec succès.";

        $to = "cariou.liam@orange.fr";

        $subject = "Confirmation d'emprunt";

        $message = "L'emprunt a été créé avec succès.\n";
        $message .= "Utilisateur: $user_name\n";
        $message .= "Matériel: $materiel_name\n";
        $message .= "Date de début: $date_debut\n";
        $message .= "Date de fin: $date_fin\n";

        $headers = "From: votre_adresse@example.com"; 

        mail($to, $subject, $message, $headers);

        header("Location: ../../pret/list.php");
        exit();
    } else {
        echo "Une erreur s'est produite lors de la création de l'emprunt.";
        error_reporting(E_ALL);
ini_set('display_errors', '1');

    }
}

?>
