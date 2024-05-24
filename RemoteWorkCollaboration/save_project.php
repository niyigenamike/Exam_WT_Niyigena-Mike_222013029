<?php
session_start();
include_once("connection/connection.php");

$userId = $_SESSION['id'];
$project_name = $_POST['project_name'];
$project_id = $_POST['project_id'];
$selectedImages = $_POST['selectedImages'];

$targetDir = "uploads/";
$uploadedImages = [];
$errors = [];

foreach ($_FILES['sharedImage']['name'] as $key => $name) {
    $targetFile = $targetDir . basename($name);
    if (move_uploaded_file($_FILES['sharedImage']['tmp_name'][$key], $targetFile)) {
        $uploadedImages[] = $name;
    } else {
        $errors[] = "Failed to upload $name";
    }
}

     $imagesString = implode(',', $uploadedImages);
    $sql = "INSERT INTO workdoneonprojects (project_name, project_id, sharedImage, userId) VALUES ('$project_name', '$project_id', '$imagesString', '$userId')";
    
    if ($conn->query($sql) === TRUE) {
        $response = ['success' => true];
    } else {
        $response = ['success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error];
    }
 

header('Content-Type: application/json');
echo json_encode($response);
$conn->close();
?>
