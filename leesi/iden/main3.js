	<?php

	$req = "SELECT * FROM id";
 
// on envoie la requ�te
$res = $cnleesi->query($req);
 
// on va scanner tous les tuples un par un
echo "<id>";
while ($data = mysqli_fetch_array($res)) {
// on affiche les r�sultats
echo "<tr><td>".$data['User']."<tr><td>" ;
}
echo "</id>";


"<tr><td>" ."<tr><td>"