<?php
session_start();
include 'server/server.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_SESSION['username'] ?? null;

    // Ensure username is available
    if (!$username) {
        echo "Username is not set.";
        exit;
    }

    // Retrieve answers from POST
    $favorite_ex = $_POST['favorite_ex'] ?? null;
    $dog_name = $_POST['dog_name'] ?? null;
    $enemy_name = $_POST['enemy_name'] ?? null;
    $childhood_friend = $_POST['childhood_friend'] ?? null;

    // Ensure all fields are provided
    if (!$favorite_ex || !$dog_name || !$enemy_name || !$childhood_friend) {
        echo "All fields are required.";
        exit;
    }

    // SQL Query
    $query = "SELECT * FROM tbl_users WHERE username = ? AND favorite_ex = ? AND dog_name = ? AND enemy_name = ? AND childhood_friend = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        echo "Error preparing statement: " . $conn->error;
        exit;
    }

    // Bind parameters and execute
    $stmt->bind_param('sssss', $username, $favorite_ex, $dog_name, $enemy_name, $childhood_friend);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if answers are correct
    if ($result->num_rows > 0) {
        header('Location: change_password_modal.php');
        exit;
    } else {
        $_SESSION['message'] = 'Incorrect answers.';
        $_SESSION['success'] = 'danger';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Recovery</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding-top: 50px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            border-radius: 4px;
        }

        .btn-primary {
            width: 100%;
            padding: 10px;
        }

        /* Styling for the alert */
        .alert {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Password Recovery</h2>

    <!-- Display Error Message -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-<?php echo $_SESSION['success']; ?>" role="alert">
            <?php 
                echo $_SESSION['message']; 
                unset($_SESSION['message']);
                unset($_SESSION['success']);
            ?>
        </div>
    <?php endif; ?>

    <!-- Form for Password Recovery -->
    <form method="POST">
        <div class="form-group">
            <label for="favorite_ex">Who was your favorite ex?</label>
            <input type="text" class="form-control" name="favorite_ex" id="favorite_ex" autocomplete="off" required>
        </div>

        <div class="form-group">
            <label for="dog_name">What is the name of your first dog?</label>
            <input type="text" class="form-control" name="dog_name" id="dog_name" autocomplete="off" required>
        </div>

        <div class="form-group">
            <label for="enemy_name">What is the name of your childhood enemy?</label>
            <input type="text" class="form-control" name="enemy_name" id="enemy_name" autocomplete="off" required>
        </div>

        <div class="form-group">
            <label for="childhood_friend">What is the name of your childhood best friend?</label>
            <input type="text" class="form-control" name="childhood_friend" id="childhood_friend" autocomplete="off" required>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
