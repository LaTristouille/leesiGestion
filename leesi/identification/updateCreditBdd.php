<?php session_start();

$User = 'Tristan';

$link = mysqli_connect("localhost", "root", "", "Leesi"); 

echo $_SESSION['resteCredit'];

$long = strlen($_SESSION['resteCredit']);
	$reste = substr($_SESSION['Credit'], -$long); 

$query2 = "UPDATE id SET Credit=$reste WHERE User='$User'";
	
 if(mysqli_query($link, $query2)){ 
    echo "Record was updated successfully."; mysqli_close($link);
		}
	else { 
    echo "ERROR: Could not able to execute $query2. "  
                   . mysqli_error($link); mysqli_close($link);
} 	

?>