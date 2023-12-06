<?php 
error_reporting(E_ERROR | E_PARSE);

?>
<?php
require_once '../php/model/emprunt.php';
require_once '../php/model/user.php';
require_once '../php/model/materiel.php';
require_once '../php/model/db.php';

$database = new Database();
$db = $database->getConnection();

$emprunt = new Emprunt($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emprunt->user_id = $_POST['user_id'];
    $emprunt->materiel_id = $_POST['materiel_id'];
    $emprunt->date_debut = $_POST['date_debut'];
    $emprunt->date_fin = $_POST['date_fin'];
    
 $location = "Location: ../php/traitement/mail2.php?id=";

    if ($emprunt->createAndUpdateMateriel()) {
      $query = "SELECT * FROM empreints ORDER BY id DESC";
      $stmt = $db->prepare($query);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
       header($location.$row['id']);

    } else {
      $query = "SELECT * FROM empreints ORDER BY id  DESC";
      $stmt = $db->prepare($query);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
         header($location.$row['id']);
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

        <h2 class="mb-4">Faire un empreint</h2>

        <form method="post" action="">

      <div class="form-group">
    <label for="user_id">Utilisateur:</label>
    <select class="form-control" name="user_id" required>
        <?php
        $database = new Database();
        $db = $database->getConnection();
        $user = new User($db);
        $students = $user->read();

        if (!empty($students)) {
            foreach ($students as $student) {
                echo "<option value='{$student['id']}'>{$student['nom']} {$student['prenom']}</option>";
            }
        } else {
            echo "<option value=''>Aucun étudiant trouvé</option>";
        }
        ?>
    </select>
</div>



        <div class="form-group">
        <label for="materiel_id">ID Matériel:</label>
        <select class="form-control" name="materiel_id" required>
        <?php
        $database = new Database();
        $db = $database->getConnection();
        $user = new Materiel($db);
        $stmt = $user->read();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            echo "<option value='{$id}'>{$nom}</option>";
        }
        ?>
    </select>
        </div>


        <div class="form-group">
        <label for="date_debut">Date de début:</label>
        <input type="date" class="form-control" name="date_debut" required><br>
        </div>


        <div class="form-group">
        <label for="date_fin">Date de fin:</label>
        <input type="date" class="form-control" name="date_fin" required><br>

        <input type="submit"  class="btn btn-primary" value="Ajouter emprunt">
    </form>


  
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