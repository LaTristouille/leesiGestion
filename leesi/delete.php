<?php require_once('C:\wamp64\www\leesi\iden\connexionPDO.php');

//delete.php

if(isset($_POST["id"]))
{
 $connect = $PDO;
 $query = "
 DELETE from events WHERE id=:id
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':id' => $_POST['id']
  )
 );
}

?>>