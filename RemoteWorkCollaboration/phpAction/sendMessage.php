<?php
session_start();
include_once("connection/connection.php");

$data = json_decode(file_get_contents('php://input'), true);

$message = $data['message'];
$sender = $_SESSION['id'];
$email = $_SESSION['email'];

$sql = "INSERT INTO chats (message, sender, email) VALUES ('$message', '$sender', '$email')";

$response = ['success' => false];

if ($conn->query($sql) === TRUE) {
    $response['success'] = true;
}

header('Content-Type: application/json');
echo json_encode($response);
$conn->close();
?>
