<?php require_once('C:\wamp64\www\leesi\iden\connexionPDO.php'); session_start();

$connect = $PDO;

$User = $_SESSION['iden'];

if(isset($_POST["id"]))
	
{ 
 $query = "
 UPDATE events 
 SET title=:title, start_event=:start_event, end_event=:end_event 
 WHERE id=:id ";
	
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
