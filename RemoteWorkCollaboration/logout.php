<?php
session_start();
include_once("./connection/connection.php");

// Check if the session contains the user's first name
if (isset($_SESSION['first_name'])) {
    $userName = $_SESSION['first_name'];
    $logInfo = "logout";
    $dateDone = date('Y-m-d H:i:s'); // Current timestamp

    // Insert the logout action into the system_log_info table
    $sql = "INSERT INTO system_log_info (logInfo, userName, dateDone) VALUES ('$logInfo', '$userName', '$dateDone')";

    if ($conn->query($sql) === TRUE) {
        // Log entry created successfully
    } else {
        // Handle the error if needed
        error_log("Error logging out: " . $conn->error);
    }
}

// Destroy the session
session_destroy();

// Redirect to the home page or login page
header('Location: ./');
exit;
?>
