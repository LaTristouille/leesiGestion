<?php require_once('../db/connexionPDO.php');

//update.php

$connect = $PDO;

if(isset($_POST["id"]))
{
 $query = "
 UPDATE abs 
 SET title=:title, start_event=:start_event, end_event=:end_event
 WHERE id=:id
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':title'  => $_POST['title'],
   ':start_event' => $_POST['start'],
   ':end_event' => $_POST['end'],
   ':id'   => $_POST['id']
  )
 );
}

?>