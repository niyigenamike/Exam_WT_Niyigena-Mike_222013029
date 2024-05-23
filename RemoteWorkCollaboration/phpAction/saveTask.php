<?php
include_once("../connection/connection.php");

$id = $_POST['task_id'];
$task_name = $_POST['task_name'];
$taskDescription = $_POST['taskDescription'];
$tool_name = $_POST['tool_name'];

if ($id == "Auto") {
    $sql = "INSERT INTO task (task_name, taskDescription, tool_name)
            VALUES ('$task_name', '$taskDescription', '$tool_name')";
} else {
    $sql = "UPDATE task SET
            task_name='$task_name', taskDescription='$taskDescription', tool_name='$tool_name'
            WHERE id=$id";
}

if ($conn->query($sql) === TRUE) {
    $response = array('status' => 'success');
} else {
    $response = array('status' => 'error', 'message' => $conn->error);
}

echo json_encode($response);
?>
