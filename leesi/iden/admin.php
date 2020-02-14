<?php require_once('C:\wamp64\www\leesi\connexion.php'); session_start();
?>
<!doctype html>

<html>
<head>
<meta charset="utf-8">
<title>Document sans titre</title>
	<link rel="stylesheet" href="../CssABS+CON.css" />
</head>

<body>
	
	<?php echo 'Bonjour ', $_SESSION['ident'];
	?> 
	
	<input type="button" id="Congés" onclick=window.location.href='gestion_congés'; value="Gestion des congés"  >
	
	<br/> <BR>
	
	<input type="button" id="Abscences" onclick=window.location.href='abs'; value="Gestion des abscences">
	
	
	
	
</body>
</html>