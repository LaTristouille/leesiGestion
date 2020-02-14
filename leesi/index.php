
<?php require_once('connexion.php'); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Document sans titre</title>
<link rel="stylesheet" href="leesi_style.css" />
</head>

<body>
	<br/> <BR>
	<p id="leesi">
	<img
		 src="leesigestion.png" 
    height="243px" 
    width="671px" 
/> </p>
	
	<!-- Création des deux boutons -->
	
	 <input type="button" id="employe"  onclick=window.location.href='iden/identification'; value="Ouvrir une session employé"  >
	
	<br/> <BR> 
	
	<input type="button" id="administration" onclick=window.location.href='iden/Identification2'; value="Ouvrir une session administration">
	
	<?php
	
?>
	
	
	
</body>
</html>