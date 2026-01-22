<?php

include ('db.php');

$delete= $_GET['delete'];

$abc = "delete from events where id= '$delete'";

$sql = mysqli_query($con, $abc);

if ($sql) {
	
	echo "<script> window.alert ('Your Selected Record deleted')</script>";
	echo "<script> window.open ('manage_events.php', '_self')</script>";
}

else {
	
	echo "not";
}


?>