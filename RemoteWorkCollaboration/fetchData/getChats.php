<?php
include_once("../connection/connection.php");

$sql = "SELECT * FROM chats ORDER BY id ASC";
$result = $conn->query($sql);

$messages = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $messages[] = [
            'id' => $row['id'],
            'message' => $row['message'],
            'sender' => $row['sender'],
            'email' => $row['email']
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($messages);
$conn->close();
?>
