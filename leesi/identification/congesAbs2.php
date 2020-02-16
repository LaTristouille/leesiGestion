<?php session_start();
?>
<!doctype html>

<html>
<head>
<meta charset="utf-8">
<title>Document sans titre</title>
	<link rel="stylesheet" href="cssAbs" />
</head>

<body>
	
	<input type="button" id="deco"  onclick=window.location.href='./admin'; value="Déconnexion" >
	
	<p id="texte">
	
	<?php echo 'Bonjour ', $_SESSION['iden'];
	?> 
	   <p>
	
	<input type="button" id="Congés" onclick=window.location.href='../gestionConges/lesConges.php'; value="Gestion des congés"  >
	
	<br/> <BR>
	
	<input type="button" id="Abscences" onclick=window.location.href='../gestionAbsences/lesAbsences.php'; value="Gestion des abscences">
	
</body>
</html>