




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

        <h2 class="mb-4">Listes des étudiants</h2>

        <!-- <a class='btn btn-primary' style="margin-bottom: 2%;" href='add.php'>Ajouter un étudiant</a> -->

<table class="table">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Email</th>
            <th>email</th>
            <th></th>
        </tr>
    </thead>
<?php
include_once '../php/model/db.php';
include_once '../php/model/user.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

$students = $user->read();

if (!empty($students)) {


    foreach ($students as $student) {
        echo "<tr>";
        echo "<td>{$student['nom']}</td>";
        echo "<td>{$student['prenom']}</td>";
        echo "<td>{$student['mail']}</td>";
        echo "<td><a class='btn btn-info btn-sm ml-2' href='details.php?id={$student['id']}'>Voir prêts</a></td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>Aucun étudiant trouvé.</p>";
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