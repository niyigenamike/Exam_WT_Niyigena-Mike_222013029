<?php
include_once("../connection/connection.php");

$response = ['status' => 'error'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $team_name = $_POST['team_name'];
    $team_description = $_POST['team_description'];
    $team_id = isset($_GET['id']) ? $_GET['id'] : null;
    $dateAdded = date('Y-m-d H:i:s');
    $teamImage = '';

    if (!empty($_FILES['teamImage']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["teamImage"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate file type
        $valid_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imageFileType, $valid_extensions)) {
            if (move_uploaded_file($_FILES["teamImage"]["tmp_name"], $target_file)) {
                $teamImage = $target_file;
            } else {
                $response['message'] = "Error uploading image.";
                echo json_encode($response);
                exit;
            }
        } else {
            $response['message'] = "Invalid image format.";
            echo json_encode($response);
            exit;
        }
    }

    if ($team_id) {
        $sql = "UPDATE team SET 
                    team_name='$team_name', 
                    team_description='$team_description', 
                    dateAdded='$dateAdded', 
                    teamImage='$teamImage' 
                WHERE id=$team_id";
    } else {
        $sql = "INSERT INTO team (team_name, team_description, dateAdded, teamImage) 
                VALUES ('$team_name', '$team_description', '$dateAdded', '$teamImage')";
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
