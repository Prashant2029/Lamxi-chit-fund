<?php

include('./includes/config.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/phpmailer/phpmailer/src/Exception.php';
require './vendor/phpmailer/phpmailer/src/PHPMailer.php';
require './vendor/phpmailer/phpmailer/src/SMTP.php';

// Function to generate OTP
function generateOTP($length = 8) {
    $otp = '';
    for ($i = 0; $i < $length; $i++) {
        $otp .= rand(0, 9);
    }
    return $otp;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email']) && isset($_POST['account_id'])) {
    $email = $_POST['email'];  // Getting email from POST data
    $account_id = $_POST['account_id'];  // Getting account ID from POST data

    // Prepare SQL query to check if the email and account ID exist in the database
    $sql = "SELECT email, account_id FROM user_info WHERE email = ? AND account_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $email, $account_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['password_acc_id'] = $account_id;

        // Generate OTP
        $otp = generateOTP();

        $_SESSION['otp'] = $otp;

        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = 0; 
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'laxmichitfund36@gmail.com';  
            $mail->Password   = 'rucv jkax cwxi zapc';  
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Recipients
            $mail->setFrom('laxmichitfund36@gmail.com', 'Password Reset');
            $mail->addAddress($email);  

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset OTP';
            $mail->Body    = 'Your One-Time Password (OTP) is: <strong>' . $otp . '</strong>';

            // Send OTP email
            $mail->send();
            header("Location: ./check_otp.php");


        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $message = "Invalid account ID or Email.";
        $messageType = "danger";
    }

    $stmt->close();
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
							<h1 class="fs-4 card-title fw-bold mb-4">Forgot Password</h1>
							<form method="POST" class="needs-validation" novalidate="" autocomplete="off">
								<div class="mb-3">
									<label for="email" class="mb-2 text-muted" for="email">Email Address</label>
									<input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required autofocus>

									<label class="mb-2 text-muted" for="accound_id" style="margin-top: 20px;">Account ID</label>
									<input id="accound_id" type="text" pattern="\d+" class="form-control" name="account_id" placeholder="Enter your Account ID" required autofocus>
								</div>

								<div class="d-flex align-items-center">
									<button type="submit" class="btn btn-primary ms-auto">
										Send OPT	
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
						Copyright &copy; 2017-2021 &mdash; Laxmi Chit Fund
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Modal for error/success message -->
    <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="messageModalLabel">Error: Invalid Account ID or Email</h5>
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

    <!-- Hidden trigger element to pass PHP message and type -->
    <div id="messageTrigger" data-message="<?= htmlspecialchars($message ?? '', ENT_QUOTES, 'UTF-8') ?>" data-type="<?= htmlspecialchars($messageType ?? '', ENT_QUOTES, 'UTF-8') ?>"></div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="./static/js/modal.js"></script>
</body>
</html>
