<?php
session_start();
// save_security_answers.php
include('server/server.php'); // Include database connection

 // Start the session if not started already

// Check if the user is logged in (Ensure admin is logged in)
if (!isset($_SESSION['id'])) {
    // Redirect to login if not logged in
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize user input to prevent SQL injection
    $favorite_ex = mysqli_real_escape_string($conn, $_POST['favorite_ex']);
    $dog_name = mysqli_real_escape_string($conn, $_POST['dog_name']);
    $enemy_name = mysqli_real_escape_string($conn, $_POST['enemy_name']);
    $childhood_friend = mysqli_real_escape_string($conn, $_POST['childhood_friend']);

    // Get the admin's ID from session
    $id = $_SESSION['id'];

    // SQL query to update the user's security answers in tbl_users table
    $sql = "UPDATE tbl_users SET 
                favorite_ex = '$favorite_ex',
                dog_name = '$dog_name',
                enemy_name = '$enemy_name',
                childhood_friend = '$childhood_friend'
            WHERE id = '$id'";

    // Check if the update query was successful
    if (mysqli_query($conn, $sql)) {
        // Notify the admin that the recovery key was set up successfully
        echo "<script>alert('Recovery key successfully set up.'); window.location.href = 'login.php';</script>";
    } else {
        // If there was an error, display a message
        echo "<script>alert('There was an error setting up your recovery key. Please try again.');</script>";
    }
}
?>

