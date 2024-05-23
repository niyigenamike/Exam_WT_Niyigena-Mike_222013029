<?php
// Start the session
session_start();

if(isset($_POST['email']) && isset($_POST['password'])) {
    // Include database connection
    include_once("../connection/connection.php");

    // Escape user inputs for security
    $user = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);
    $pass = md5($pass);

    if($user == "" ||  $pass == "") {
        $response = array('status' => 'failed', 'msg' => 'Email or password cannot be empty.');
    } else {
        // Query to check if user exists with provided credentials
        $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$user' AND password='$pass'")
                  or die("Could not execute the select query.");
        
        // Fetch user details
        $row = mysqli_fetch_assoc($result);
        if(!empty($row)) {
            // Store user details in session variables
            $_SESSION['valid'] = $row['first_name'];
            $_SESSION['first_name'] = $row['first_name'];
            $_SESSION['last_name'] = $row['last_name'];
            $_SESSION['id'] = $row['id'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['email'] = $row['email'];
            if (isset($_SESSION['first_name'])) {
                $userName = $_SESSION['first_name'];
                $logInfo = "LogIn";
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
            $response = array('status' => 'success');
        } else {
            
            
            $response = array('status' => 'incorrect');
        }
    }

    // Return JSON response
    echo json_encode($response);
} else {
    // Handle if email and password are not set (optional)
}
?>
