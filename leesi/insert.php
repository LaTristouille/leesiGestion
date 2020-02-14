<?php

//insert.php

try{
   $connect = new PDO('mysql:host=localhost;dbname=leesi', 'root', '');
}catch(PDOException $e){
   die('Erreur : '.$e->getMessage());
}

if(isset($_POST["title"]))
{ 
	error_log( "insert.php");
 $query = "
 INSERT INTO events 
 (title, start_event, end_event,endReal) 
 VALUES (:title, :start_event, :end_event,:endReal)
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':title'  => $_POST['title'],
   ':start_event' => $_POST['start'],
   ':end_event' => $_POST['end'],
	  ':endReal' => $_POST['endReal']
  )
 );
}

?>