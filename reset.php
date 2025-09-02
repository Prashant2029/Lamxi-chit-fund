<?php 
include("./includes/config.php");

$message = ""; // Initialize an empty message
$messageType = ""; // Initialize the type of the message

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['old_password']) && isset($_POST['new_password']) && isset($_POST['password'])) {
    $accountId = $_SESSION['account_id'] ?? null;
    $oldPassword = $_POST['old_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['password'];

    if ($accountId) {
        $sql = "SELECT password FROM user_info WHERE account_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $accountId);
        $stmt->execute();
        $stmt->bind_result($password);

        if ($stmt->fetch()) {
            $stmt->close();
            if (password_verify($oldPassword, $password)) { // Use === for exact comparison
                if ($newPassword === $confirmPassword) {
                    $sql = "UPDATE user_info SET password = ? WHERE account_id = ?";
                    $stmt = $conn->prepare($sql);
                    $newPassword = password_hash($confirmPassword, PASSWORD_DEFAULT);
                    $stmt->bind_param("si", $newPassword, $accountId);
                    $stmt->execute();
                    $stmt->close();

                    $message = "Password has been reset successfully.";
                    $messageType = "success";
                } else {
                    $message = "New password and confirm password do not match.";
                    $messageType = "warning";
                }
            } else {
                $message = "Invalid current password.";
                $messageType = "danger";
            }
        } else {
            $message = "Invalid account ID.";
            $messageType = "danger";
        }
    } else {
        $message = "Session expired. Please log in again.";
        $messageType = "danger";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
        }
    </style>
</head>
<body>

    <?php include('./Partials/header.php'); ?>

    <main class="py-5 d-flex align-items-center justify-content-center" style="min-height: 10vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="card-title text-center">Reset Your Password</h5>
                            <form method="POST">
                                <div class="mb-3">
                                    <label for="old_password" class="form-label">Current Password</label>
                                    <input type="password" class="form-control" id="old_password" name="old_password" placeholder="Enter your current password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter new password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Confirm your new password" required>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Confirm</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal -->
    <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Message will be inserted dynamically -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div id="messageTrigger" data-message="<?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>" data-type="<?= htmlspecialchars($messageType, ENT_QUOTES, 'UTF-8') ?>"></div>

    <?php include('./Partials/footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./static/js/modal.js"></script>
</body>
</html>
