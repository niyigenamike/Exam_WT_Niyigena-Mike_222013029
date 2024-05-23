<?php
include_once("../connection/connection.php");

$response = ['status' => 'error'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullnames = $_POST['fullnames'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $status = $_POST['status'];
    $age = $_POST['age'];
    $projectImage = '';
    $auditor_id = isset($_GET['id']) ? $_GET['id'] : null;
    $date_ = date('Y-m-d H:i:s');
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
    if ($auditor_id) {
        $sql = "UPDATE auditor SET 
                    fullnames='$fullnames', 
                    phone='$phone', 
                    email='$email', 
                    address='$address', 
                    gender='$gender', 
                    status='$status', 
                    age='$age', 
                    image='$projectImage', 
                    date_='$date_'
                WHERE id=$auditor_id";
    } else {
        $sql = "INSERT INTO auditor (fullnames, phone, email, address, gender, status, age, image, date_) 
                VALUES ('$fullnames', '$phone', '$email', '$address', '$gender', '$status', '$age', '$projectImage', '$date_')";
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
