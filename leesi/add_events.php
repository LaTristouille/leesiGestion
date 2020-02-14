<?php

try {
 $bdd = new PDO('mysql:host=localhost;dbname=leesi', 'root', '');
 } catch(Exception $e) {
 exit('Impossible de se connecter à la base de données.');
 }

$title=$_POST['title'];
$start=$_POST['start'];
$end=$_POST['end'];
 
$sql = "INSERT INTO evenement (title, start, end) VALUES (:title, :start, :end)";
$q = $bdd->prepare($sql);
$q->execute(array(':title'=>$title, ':start'=>$start, ':end'=>$end));

?>