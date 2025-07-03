<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'templates/header.php'; ?>
    <title>Login - Barangay Management System</title>
    <style>
        .logos-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .logos-container img {
            height: 80px;
            width: auto;
            margin: 0 10px;
        }
        .forgot-password {
            text-align: center;
            margin-top: 10px;
        }
        .forgot-password a {
            color: #007bff;
            text-decoration: none;
        }
        .forgot-password a:hover {
            text-decoration: underline;
        }

        /* Notification styles */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #f44336; /* Red background for error */
            color: white;
            padding: 15px 20px;
            border-radius: 5px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            display: none;
        }

        .notification.success {
            background-color: #4CAF50; /* Green background for success */
        }

        .notification button {
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
        }
    </style>
</head>
<body class="login">
    <?php include 'templates/loading_screen.php'; ?>

    <!-- Notification Section -->
    <div id="notification" class="notification">
        <p id="notification-message"></p>
        <button onclick="closeNotification()">×</button>
    </div>

    <div class="wrapper wrapper-login">
        <div class="container container-login animated fadeIn">
            <!-- Logos Section -->
            <div class="logos-container">
                <img src="assets/img/barangay_logo.jpeg" alt="Barangay Logo">
                <img src="assets/img/dilg_logo.png" alt="DILG Logo">
                <img src="assets/img/municipality_logo.jpg" alt="Municipality Logo">
            </div>

            <!-- PHP Notification Logic -->
            <?php
            session_start(); // Ensure session is started
            if (isset($_SESSION['message'])): ?>
                <script>
                    // Show notification based on session message
                    showNotification("<?= $_SESSION['message']; ?>", "<?= $_SESSION['success'] === 'success' ? 'success' : 'error'; ?>");
                </script>
                <?php unset($_SESSION['message']); // Clear the message after showing it ?>
            <?php endif; ?>

            <!-- Sign In Title -->
            <h3 class="text-center">Sign In Here</h3>

            <!-- Login Form -->
            <div class="login-form">
                <form method="POST" action="model/login.php">
                    <div class="form-group form-floating-label">
                        <input id="username" name="username" type="text" class="form-control input-border-bottom" required>
                        <label for="username" class="placeholder">Username</label>
                    </div>
                    <div class="form-group form-floating-label">
                        <input id="password" name="password" type="password" class="form-control input-border-bottom" required>
                        <label for="password" class="placeholder">Password</label>
                        <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                    </div>
                    <div class="form-action mb-3">
                        <button type="submit" class="btn btn-primary btn-rounded btn-login">Sign In</button>
                    </div>
                </form>

                <!-- Forgot Password Link -->
                <div class="forgot-password">
                    <a href="forgot_password.php" class="no-reload">Forgot Password?</a>
                </div>
            </div>
        </div>
    </div>
    <?php include 'templates/footer.php'; ?>

    <!-- JavaScript for Notification -->
    <script>
        function showNotification(message, type = 'error') {
            const notification = document.getElementById('notification');
            const messageElement = document.getElementById('notification-message');
            messageElement.textContent = message;

            // Apply success or error style
            if (type === 'success') {
                notification.classList.add('success');
                notification.classList.remove('error');
            } else {
                notification.classList.add('error');
                notification.classList.remove('success');
            }

            notification.style.display = 'flex'; // Show notification

            // Automatically hide after 3 seconds
            setTimeout(() => {
                notification.style.display = 'none';
            }, 3000);
        }

        function closeNotification() {
            const notification = document.getElementById('notification');
            notification.style.display = 'none';
        }
    </script>
</body>
</html>
