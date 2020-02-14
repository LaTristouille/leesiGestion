<?php require_once('C:\wamp64\www\leesi\iden\connexionPDO.php');

//insert.php
$connect = $PDO;

if(isset($_POST["title"]))
{
 $query = "
 INSERT INTO abs 
 (title, start_event, end_event) 
 VALUES (:title, :start_event, :end_event)
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':title'  => $_POST['title'],
   ':start_event' => $_POST['start'],
   ':end_event' => $_POST['end']
  )
 );
}

?>