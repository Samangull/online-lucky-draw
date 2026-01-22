<?php

include ('db.php');

$delete= $_GET['delete'];

$abc = "delete from users where id= '$delete'";

$sql = mysqli_query($con, $abc);

if ($sql) {
	
	echo "<script> window.alert ('Your Selected Record deleted')</script>";
	echo "<script>window.open('users.php','_self')</script>";
}

else {
	
	echo "not";
}


?>