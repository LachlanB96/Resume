<?php
function db_conn($query){
	$connection = mysqli_connect("localhost","root","mysql", "resume");
	if (!$connection)
		die("Could not connect to Server");
	$query_string = $query;
	return mysqli_query($connection, $query_string);
}
?>