<?php
// Check if the form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection
    include_once("../connection/connection.php");

    // Escape user inputs for security
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $password = md5($pass);

    // Query to insert user data into the database
    $sql = "INSERT INTO users (first_name, last_name, contact, gender, email, password, role) 
            VALUES ('$firstname', '$lastname', '$contact', '$gender', '$email', '$password', '$role')";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        // Return success response
        echo json_encode(array("status" => "success"));
    } else {
        // Return error response
        echo json_encode(array("status" => "failed", "msg" => "Error: " . mysqli_error($conn)));
    }

    // Close database connection
    mysqli_close($conn);
} else {
    // Return error response if request method is not POST
    echo json_encode(array("status" => "failed", "msg" => "Invalid request method"));
}
?>
