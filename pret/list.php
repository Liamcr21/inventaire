<?php 
error_reporting(E_ERROR | E_PARSE);

?>

<!doctype html>
<html lang="fr">
  <head>
  	<title>Inventaire NWS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="../assets/css/style.css">
  </head>
  <body>
		
		<div class="wrapper d-flex align-items-stretch">
			<nav id="sidebar">
				<div class="custom-menu">
					<button type="button" id="sidebarCollapse" class="btn btn-primary">
	          <i class="fa fa-bars"></i>
	          <span class="sr-only">Toggle Menu</span>
	        </button>
        </div>
				<div class="p-4 pt-5">
		  		<h1><a href="../" class="logo"><img src="../assets/images/nws-logo.png" width="50%"></a></h1>
	        <ul class="list-unstyled components mb-5">
	   
	          <li>
	              <a href="../">Accueil</a>
	          </li>
	          <li>
              <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Empreint</a>
              <ul class="collapse list-unstyled" id="pageSubmenu">
                <li>
                    <a href="add.php">Faire un empreint</a>
                </li>
                <li>
                    <a href="list.php">Empreint en cours</a>
                </li>
              </ul>
	          </li>
	          <li>
              <a href="../materiel/list.php">Matériel</a>
	          </li>
            
            <li>
              <a href="../user/list.php">Etudiant</a>
	          </li>
	        
	        </ul>


	        <div class="footer" id="footer">
	    
	        </div>

	      </div>
    	</nav>

      <div id="content" class="p-4 p-md-5 pt-5">

        <h2 class="mb-4">Empreint en cours</h2>

        <table class="table">
    <thead>
        <tr>
            <th> Utilisateur</th>
            <th>Nom Matériel</th>
            <th>Date de début</th>
            <th>Date de fin</th>
            <th>Situation</th>
            <th>Rappel</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
<?php
require_once '../php/model/emprunt.php';
require_once '../php/model/db.php';
require_once '../php/model/user.php';

$database = new Database();
$db = $database->getConnection();
$emprunt = new Emprunt($db);
$user = new User($db);

$stmt = $emprunt->read();

if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        
// 
/*
$userQuery = "SELECT user_id FROM empreints WHERE id = :user_id";
$userStmt = $db->prepare($userQuery);
$userStmt->bindParam(":user_id", $user_id);
var_dump($user_id);
if ($userStmt->execute()) {
    $userRow = $userStmt->fetch(PDO::FETCH_ASSOC);
    $nomUtilisateur = isset($userRow['nom']) ? $userRow['nom'] : "Utilisateur inconnu";
} else {
    $nomUtilisateur = "Erreur lors de la récupération du nom de l'utilisateur";
}
*/

// Utilisez directement $user_id
$userList = $emprunt->readAllUsers();

$userDetails = $emprunt->readSingleUser($userList, $user_id);



        $materielQuery = "SELECT nom FROM materiels WHERE id = :materiel_id";
        $materielStmt = $db->prepare($materielQuery);
        $materielStmt->bindParam(":materiel_id", $materiel_id);
        if ($materielStmt->execute()) {
            $materielRow = $materielStmt->fetch(PDO::FETCH_ASSOC);
            $nomMateriel = isset($materielRow['nom']) ? $materielRow['nom'] : "Matériel inconnu";
        } else {
            $nomMateriel = "Erreur lors de la récupération du nom du matériel";
            echo "Erreur lors de la récupération du nom du matériel.";
        }

        echo "<tr>";
  echo "<td>{$userDetails['nom']} {$userDetails['prenom']}</td>";

        echo "<td>{$nomMateriel}</td>";
      

        $date_debut_formattee = date('d/m/Y ', strtotime($date_debut));
        echo "<td>{$date_debut_formattee}</td>";

        $date_fin_formattee = date('d/m/Y ', strtotime($date_fin));
        echo "<td>{$date_fin_formattee}</td>";
        echo "<td>";


        $dateDebutTimestamp = strtotime($date_debut);
        $dateFinTimestamp = strtotime($date_fin);
        $todayTimestamp = strtotime(date('Y-m-d'));

        if ($todayTimestamp >= $dateDebutTimestamp && $todayTimestamp <= $dateFinTimestamp) {
            echo "En cours";
        } elseif ($todayTimestamp > $dateFinTimestamp) {
            echo "Retard";
        } else {
            echo "Pas commencé";
        }

        echo "</td>";
        echo "<td>";
        echo "<a href='../php/traitement/mail2.php?id={$id}' class='btn btn-info btn-sm ml-2'>Rappel</a>";
        echo "</td>";
        echo "<td>";
        echo "<a href='delete.php?id={$id}' class='btn btn-danger btn-sm ml-2'>Cloturer</a>";
        echo "</td>";
        echo "</tr>";
        





    }
} else {
    echo "<tr><td colspan='5'>Aucun emprunt trouvé.</td></tr>";
}
?>


    </tbody>
</table>



  
      </div>



		</div>
        <script>
        function getDate() {
            const today = new Date();
            const day = today.getDate();
            const month = today.getMonth() + 1; 
            const year = today.getFullYear();

            return `${day}/${month}/${year}`;
        }
        document.getElementById('footer').innerHTML = ` ${getDate()}`;
    </script>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/popper.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/main.js"></script>
  </body>
</html>