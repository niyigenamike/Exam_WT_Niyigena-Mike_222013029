
<?php

$databaseHost = 'localhost';
$databaseName = 'remotework';
$databaseUsername = 'root';
$databasePassword = '';

$conn = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName); 

if($conn){
	echo "";
}else {
	 echo "error while connecting to the server";
}
?>