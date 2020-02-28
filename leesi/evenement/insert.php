<?php
require_once('../db/connexion.php');
require_once('../db/connexionPDO.php');
session_start();

try {
	$connect = $PDO;
} catch (PDOException $e) {
	die('Erreur : ' . $e->getMessage());
}


	if (isset($_POST["title"]) && $_SESSION['conge'] < 20) {
		error_log("insert.php");
		$query = "
 INSERT INTO events 
 (title, start_event, end_event,endReal, alert) 
 VALUES (:title, :start_event, :end_event,:endReal, :alert)
 ";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':title' => $_POST['title'],
				':start_event' => $_POST['start'],
				':end_event' => $_POST['end'],
				':endReal' => $_POST['endReal'],
				':alert' => $_POST['alert']
			)
		);

	
		error_log("insert.php ok ".$_POST['title']." " .$_POST['start']." " .$_POST['end']." " .$_POST['endReal']." " .$_POST['alert'] );

	}

