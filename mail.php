<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/phpmailer/phpmailer/src/Exception.php';
require './vendor/phpmailer/phpmailer/src/PHPMailer.php';
require './vendor/phpmailer/phpmailer/src/SMTP.php';

// Function to generate OTP
function generateOTP($length = 6) {
    $otp = '';
    for ($i = 0; $i < $length; $i++) {
        $otp .= rand(0, 9);
    }
    return $otp;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = $_SESSION['email'];

    // Generate OTP
    $otp = generateOTP();

    // Store OTP in session to verify later
    $_SESSION['otp'] = $otp;
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = 2; // Enable debugging
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'laxmichitfund36@gmail.com';  // Replace with your email
        $mail->Password   = 'rucv jkax cwxi zapc';     // Replace with your app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('laxmichitfund36@gmail.com', 'Password Reset');
        $mail->addAddress($email); // The email the OTP will be sent to

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset OTP';
        $mail->Body    = 'Your One-Time Password (OTP) is: <strong>' . $otp . '</strong>';

        // Send OTP email
        $mail->send();

        echo 'OTP has been sent to your email address.';

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
