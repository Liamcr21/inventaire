


<?php
include_once '../php/model/db.php';
include_once '../php/model/materiel.php';

$database = new Database();
$db = $database->getConnection();
$materiel = new Materiel($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $materiel->nom = $_POST["nom"];
    $materiel->quantite_disponible = $_POST["quantite_disponible"];

    if ($materiel->create()) {
        header("Location: list.php");
        exit();
    } else {
        echo "Erreur lors de l'ajout du matériel.";
    }
}
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
		  		<h1><a href="../index.php" class="logo"><img src="../assets/images/nws-logo.png" width="50%"></a></h1>
	        <ul class="list-unstyled components mb-5">
	   
	          <li>
	              <a href="../index.php">Accueil</a>
	          </li>
	          <li>
              <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Empreint</a>
              <ul class="collapse list-unstyled" id="pageSubmenu">
                <li>
                    <a href="../pret/add.php">Faire un empreint</a>
                </li>
                <li>
                    <a href="../pret/list.php">Empreint en cours</a>
                </li>
              </ul>
	          </li>
	          <li>
              <a href="../materiel/list.php">Matériel</a>
	          </li>
              
            <li>
              <a href="list.php">Etudiant</a>
	          </li>
	       
	        </ul>


	        <div class="footer" id="footer">
	    
	        </div>

	      </div>
    	</nav>

      <div id="content" class="p-4 p-md-5 pt-5">


        <?php
include_once '../php/model/db.php';
include_once '../php/model/emprunt.php';
include_once '../php/model/user.php';

$database = new Database();
$db = $database->getConnection();
$emprunt = new Emprunt($db);

if (isset($_GET['id'])) {
    $emprunt->user_id = $_GET['id'];

    $stmt = $emprunt->readUserEmprunts();

    echo "<div id='content' class='p-4 p-md-5 pt-5'>";

    $user = new User($db);
    $user->id = $_GET['id'];
    $user->readOne();
    echo "<h2 class='mb-4'>{$user->nom}</h2>    ";
    echo "<p><strong>Email:</strong> {$user->email}</p>";
    echo "<p><strong>Rôle:</strong> {$user->role}</p>";

    echo "<h3 class='mb-3'>Prêts en cours</h3>";
    echo "<table class='table'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Matériel </th>";
    echo "<th>Date de début</th>";
    echo "<th>Date de fin</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        echo "<tr>";

        $materielQuery = "SELECT nom FROM materiels WHERE id = :materiel_id";
        $materielStmt = $db->prepare($materielQuery);
        $materielStmt->bindParam(":materiel_id", $materiel_id);
        if ($materielStmt->execute()) {
            $materielRow = $materielStmt->fetch(PDO::FETCH_ASSOC);
            $nomMateriel = isset($materielRow['nom']) ? $materielRow['nom'] : "Matériel inconnu";
        } else {
            $nomMateriel = "Erreur lors de la récupération du nom du matériel";
        }
        echo "<td>{$nomMateriel}</td>";
        echo "<td>{$date_debut}</td>";
        echo "<td>{$date_fin}</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
    echo "</div>";
} else {
    header("Location: list.php");
}
?>
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