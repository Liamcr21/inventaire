
<?php
include_once '../php//model/db.php';
include_once '../php/model/materiel.php';

$database = new Database();
$db = $database->getConnection();
$materiel = new Materiel($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $materiel->id = $_POST["modifier_id"];
    $materiel->nom = $_POST["modifier_nom"];
    $materiel->quantite_disponible = $_POST["modifier_quantite_disponible"];

    if ($materiel->update()) {
        header("Location: list.php");
        exit();
    } else {
        echo "Erreur lors de la modification du matériel.";
    }
}

// Récupérer les données du matériel à partir de l'ID
if (isset($_GET['id'])) {
    $materiel->id = $_GET['id'];
    $materiel->readOne();
} else {
    echo "ID du matériel non spécifié.";
    exit();
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
                    <a href="../pret/add.php">Faire un empreint</a>
                </li>
                <li>
                    <a href="../pret/list.php">Empreint en cours</a>
                </li>
              </ul>
	          </li>
	          <li>
              <a href="list.php">Matériel</a>
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

        <h2 class="mb-4">MAJ <?php echo $materiel->nom; ?> </h2>

        <form action="" method="post">
        <input type="hidden" id="modifier_id" name="modifier_id" value="<?php echo $materiel->id; ?>">

        <div class="form-group">
            <label for="modifier_nom">Nom du matériel:</label>
            <input type="text" class="form-control" id="modifier_nom" name="modifier_nom" value="<?php echo $materiel->nom; ?>" required>
        </div>

        <div class="form-group">
            <label for="modifier_quantite_disponible">Quantité disponible:</label>
            <input type="number" class="form-control" id="modifier_quantite_disponible" name="modifier_quantite_disponible" value="<?php echo $materiel->quantite_disponible; ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
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