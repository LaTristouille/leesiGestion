	<?php

	$req = "SELECT * FROM id";
 
// on envoie la requête
$res = $cnleesi->query($req);
 
// on va scanner tous les tuples un par un
echo "<id>";
while ($data = mysqli_fetch_array($res)) {
// on affiche les résultats
echo "<tr><td>".$data['User']."<tr><td>" ;
}
echo "</id>";


"<tr><td>" ."<tr><td>"