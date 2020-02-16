<?php require_once('../db/connexionPDO.php');

//delete.php

if(isset($_POST["id"]))
{
 $connect = $PDO;
 $query = "
 DELETE from abs WHERE id=:id
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':id' => $_POST['id']
  )
 );
}

?>>