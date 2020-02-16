<?php require_once('../db/connexion.php'); session_start();
?>
<!doctype html>

<html> 
<head>
<meta charset="utf-8">
<title>Document sans titre</title>

	<link rel="stylesheet" href="../css/cssIden.css" />

</head>	
	
<body>
	
	<input type="button" id="retour"  onclick=window.location.href='../'; value="Retour"  >
	
	<h1 id="titre"> Entrez vos identifiants administration </h1>
	
	<hr style="width: 130px; color: black; background-color: #4481f1; align: 'center'; height: 2px;" />
	
	<!-- Création des champs pour entrer les identifiants -->
	
	<div id="identification"> 
	
		<form name="user" method="post" action="">
		<input  id="user" type="text" name="user" placeholder="Entrez un utilisateur" />
				
		<form name=mdp method="post" action="">
		<input id="mdp" type="text" name="mdp" placeholder="Entrez un mot de passe"/>
			
			<!-- création du bouton pour valider les identifiants--> 
			
			   <input class="bt" type="submit" name="btsubmit" onClick="identification();" />
		
			<?php 
			
			$user=''; $credit='';
			
			$reponse= "Saisissez (de nouveau) vos identifiants";
			
			//on récupére les valeurs entrées en identifiants
			
			if(isset($_POST['btsubmit']))   {	
			  $user=$_POST['user']; $mdp=$_POST['mdp']; $_SESSION['iden']= $user ; $_SESSION['mp']=$mdp; 
			}		
			
		//requète pour récupérer les identifiants dans la BDD 
			
			$req = "SELECT * FROM admin";

			// on envoie la requête

			$res = $cnleesi->query($req);
			
			// on va scanner tous les tuples un par un

			while ($data = mysqli_fetch_array($res)) {

	// on affiche les résultats
				
 "<tr><td>".$data['User']."</td><td>".$data['Mdp']."</td></tr>"; 	
			
		//si on rentre les bons identifiants 
			
			 if( $user === $data[0] && $mdp === $data[1]) 
				 
			{ 
				 header('Location: congesAbs2.php'); exit();
			 }
				
			else { }
}
		?>
 
        </p>
		
			
			
			

	
	</body>
</html>