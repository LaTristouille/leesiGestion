<?php require_once('C:\wamp64\www\leesi\connexion.php'); session_start();
?>
<!doctype html>

<html>
<head>
<meta charset="utf-8">
<title>Document sans titre</title>
	<link rel="stylesheet" href="CssAbs.css" />
</head>

<body>
	
	<input type="button" id="deco"  onclick=window.location.href='http://localhost/leesi/iden/identification2'; value="Déconnexion" >
	
	<p id="texte">
	
	<?php echo 'Bonjour ', $_SESSION['iden'];
	?> 
	   <p>
	
	<input type="button" id="Congés" onclick=window.location.href='gestionConge2.php'; value="Gestion des congés"  >
	
	<br/> <BR>
	
	<input type="button" id="Abscences" onclick=window.location.href='abs2'; value="Gestion des abscences">
	
</body>
</html>