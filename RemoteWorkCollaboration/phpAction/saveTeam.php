<?php
include_once("../connection/connection.php");

$team_id = $_POST['team_id'];
$team_name = $_POST['team_name'];
$team_description = $_POST['team_description'];
$dateCreated = $_POST['dateCreated'];
$teamImage = '';

if (isset($_FILES['teamImage']) && $_FILES['teamImage']['error'] == 0) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["teamImage"]["name"]);
    if (move_uploaded_file($_FILES["teamImage"]["tmp_name"], $target_file)) {
        $teamImage = $target_file;
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to upload image']);
        exit;
    }
}

if ($team_id == 'Auto') {
    $sql = "INSERT INTO team (team_name, team_description, dateCreated, teamImage) VALUES ('$team_name', '$team_description', '$dateCreated', '$teamImage')";
} else {
    if ($teamImage != '') {
        $sql = "UPDATE team SET team_name='$team_name', team_description='$team_description', dateCreated='$dateCreated', teamImage='$teamImage' WHERE id=$team_id";
    } else {
        $sql = "UPDATE team SET team_name='$team_name', team_description='$team_description', dateCreated='$dateCreated' WHERE id=$team_id";
    }
}

if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => $conn->error]);
}
?>
