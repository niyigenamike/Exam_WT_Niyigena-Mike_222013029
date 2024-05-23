
<?php

$databaseHost = 'localhost';
$databaseName = 'book_shop_db';
$databaseUsername = 'root';
$databasePassword = '';

$conn = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName); 

if($conn){
	echo "";
}else {
	 echo "error while connecting to the server";
}
?><?php 
 
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM lecture WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "error", "message" => "Error deleting record: " . $conn->error));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "ID parameter not set"));
}
?>
