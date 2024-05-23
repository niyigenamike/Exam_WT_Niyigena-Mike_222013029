<?php
include_once("../connection/connection.php");

$response = ['status' => 'error'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $project_name = $_POST['project_name'];
    $project_description = $_POST['project_description'];
    $project_id = isset($_GET['id']) ? $_GET['id'] : null;
    $dateCreated = date('Y-m-d H:i:s');
    $projectImage = '';

    if (!empty($_FILES['projectImage']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["projectImage"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate file type
        $valid_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imageFileType, $valid_extensions)) {
            if (move_uploaded_file($_FILES["projectImage"]["tmp_name"], $target_file)) {
                $projectImage = $target_file;
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

    if ($project_id) {
        $sql = "UPDATE projects SET 
                    project_name='$project_name', 
                    project_description='$project_description', 
                    dateCreated='$dateCreated', 
                    projectImage='$projectImage' 
                WHERE id=$project_id";
    } else {
        $sql = "INSERT INTO projects (project_name, project_description, dateCreated, projectImage) 
                VALUES ('$project_name', '$project_description', '$dateCreated', '$projectImage')";
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
