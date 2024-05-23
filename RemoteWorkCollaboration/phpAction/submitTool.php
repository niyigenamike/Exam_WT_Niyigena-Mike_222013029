<?php
include_once("../connection/connection.php");

$response = ['status' => 'error'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tool_name = $_POST['tool_name'];
    $toolDescription = $_POST['toolDescription'];
    $tool_image = $_POST['tool_image'];
    $tool_id = isset($_GET['id']) ? $_GET['id'] : null;

    if ($tool_id) {
        $sql = "UPDATE tools SET 
                    tool_name='$tool_name', 
                    toolDescription='$toolDescription', 
                    tool_image='$tool_image'
                WHERE id=$tool_id";
    } else {
        $sql = "INSERT INTO tools (tool_name, toolDescription, tool_image) 
                VALUES ('$tool_name', '$toolDescription', '$tool_image')";
    }

    if ($conn->query($sql) === TRUE) {
        $response['status'] = 'success';
    } else {
        $response['message'] = "Error: " . $conn->error;
    }
}

$conn->close();
echo json_encode($response);
?>
