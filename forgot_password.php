<?php
// Start session at the very top of the page


// Include database connection
include 'server/server.php'; // Adjust the path as necessary

// Include the main header


// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);

     if (empty($username)) {
        $_SESSION['message'] = "Username cannot be empty.";
        $_SESSION['success'] = false;
        header('Location: forgot_password.php'); // Refresh the page with the message
        exit();
    } 

    // Check if username exists in the database
    $query = $conn->prepare("SELECT * FROM tbl_users WHERE user_type IN ('administrator') AND username = ?");
    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        // Username exists, redirect to the security questions page
        $_SESSION['username'] = $username; // Store username in session
        header('Location: security_questions.php');
        exit();
    } else {
        // Username not found
        $_SESSION['message'] = "Username not found. Please try again.";
        $_SESSION['success'] = false;
        header('Location: forgot_password.php'); // Refresh with error message
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'templates/header.php'; ?>
    <title>Forgot Password - Barangay Management System</title>
    <style>
        .forgot-password-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #fff;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .forgot-password-container h3 {
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .btn-submit {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-submit:hover {
            background-color: #0056b3;
        }
        .alert {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="forgot-password-container">
        <h3>Forgot Password</h3>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?= $_SESSION['success'] ? 'success' : 'danger'; ?>" role="alert">
                <?= $_SESSION['message']; ?>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif ?>

        <form method="POST" action="forgot_password.php">
            <div class="form-group">
                <input type="text" name="username" class="form-control" placeholder="Enter your username" autocomplete="off"required>
            </div>
            <button type="submit" class="btn-submit">Submit</button>
        </form>
    </div>
</body>
</html>
