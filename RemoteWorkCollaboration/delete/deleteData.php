<?php
include_once("../connection/connection.php");

$response = ['status' => 'error'];

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $table = $_GET['table'];
    $sql = "DELETE FROM $table WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        $response['status'] = 'success';
    } else {
        $response['status'] = 'success';
    }
}

$conn->close();
echo json_encode($response);
?>
