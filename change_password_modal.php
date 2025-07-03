<?php 
    session_start(); 
    include 'templates/header.php'; // Include necessary header or layout code
?>

<!-- Modal for Change Password -->
<div id="changepassword" class="modal" tabindex="-1" role="dialog" style="display: block;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reset Password</h5>
                <!-- Modify the close button to include redirect -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.href='login.php';">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form to change password -->
                <form method="POST" action="model/reset_password.php">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" name="username" id="username" class="form-control" 
                               value="<?php echo $_SESSION['username']; ?>" readonly required>
                    </div>

                    <div class="form-group">
                        <label for="new_pass">New Password:</label>
                        <input type="password" name="new_pass" id="new_pass" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="con_pass">Confirm New Password:</label>
                        <input type="password" name="con_pass" id="con_pass" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

                <!-- Display feedback messages -->
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-<?php echo $_SESSION['success']; ?> mt-3">
                        <?php 
                            echo $_SESSION['message']; 
                            unset($_SESSION['message']);
                            unset($_SESSION['success']);
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; // Include the footer code ?>
                    