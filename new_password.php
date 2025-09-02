<?php 
	include('./includes/config.php');

	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['new_password']) && isset($_POST['password'])) {
		$newPassword = $_POST['new_password'];
		$password = $_POST['password'];

		if ($newPassword === $password) {
			$accountId = $_SESSION['password_acc_id'];

			if ($accountId) {
				$sql = "UPDATE user_info SET password = ? WHERE account_id = ?";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param("si", $newPassword, $accountId);
				$stmt->execute();
				$stmt->close();

				// Redirect to the login page after successful password change
				header("Location: index.php");
				exit(); // Make sure no further code runs after the redirect

			} else {
				$message = "Invalid account ID.";
				$messageType = "danger";
			}
		} else {
			$message = "New password and confirm password do not match.";
			$messageType = "warning";
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Muhamad Nauval Azhar">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="description" content="This is a login page template based on Bootstrap 5">
	<title>Forgot Password</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>

<body>
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-sm-center h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
					<div class="text-center my-5">
						<img src="./static/img/img6.jpg" alt="logo" width="100" style="border-radius: 50px;">
					</div>
					<div class="card shadow-lg">
						<div class="card-body p-5">
							<h1 class="fs-4 card-title fw-bold mb-4">New Password</h1>
							<form method="POST" class="needs-validation" novalidate="" autocomplete="off">
								<div class="mb-3">
									<label for="new_password" class="mb-2 text-muted">Enter Your New Password</label>
									<input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter your new password" required autofocus>

									<label for="password" class="mb-2 text-muted" style="margin-top: 20px;">Confirm Your Password</label>
									<input id="password" type="password" class="form-control" name="password" placeholder="Confirm Your password" required autofocus>
								</div>

								<div class="d-flex align-items-center">
									<button type="submit" class="btn btn-primary ms-auto">
										Update Password	
									</button>
								</div>
							</form>
						</div>
						<div class="card-footer py-3 border-0">
							<div class="text-center">
								Remember your password? <a href="./index.php" class="text-dark">Login</a>
							</div>
						</div>
					</div>
					<div class="text-center mt-5 text-muted">
						Copyright &copy; 2017-2021 &mdash; Your Company 
					</div>
				</div>
			</div>
		</div>
	</section>

	<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="messageModalLabel">Password Changing</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<?= isset($message) ? htmlspecialchars($message) : '' ?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<div id="messageTrigger" data-message="<?= htmlspecialchars($message ?? '', ENT_QUOTES, 'UTF-8') ?>" data-type="<?= htmlspecialchars($messageType ?? '', ENT_QUOTES, 'UTF-8') ?>"></div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
	<script src="./static/js/modal.js"></script>
</body>
</html>
