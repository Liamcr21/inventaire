<?php 



// Supposons que vous ayez déjà récupéré l'`user_id` de la base de données
$user_id_from_database = 1; // Remplacez par la manière dont vous récupérez l'`user_id`

// ...

// Utilisez la fonction pour récupérer la liste complète depuis l'API
$userList = $user->readAllUsers();

// Utilisez la fonction pour récupérer les détails de l'utilisateur spécifique par ID
$userDetails = $user->readSingleUser($userList, $user_id_from_database);

if ($userDetails) {
    // Afficher les détails de l'utilisateur
    echo "Nom: {$userDetails['nom']}, Prénom: {$userDetails['prenom']}, Mail: {$userDetails['mail']}";
} else {
    // L'utilisateur n'a pas été trouvé
    echo "Utilisateur non trouvé.";
}



?>