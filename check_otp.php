<?php 
    include('./includes/config.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['otp'])) {
        $otp = $_POST['otp'];

        if ($otp == $_SESSION['otp']) {
            header("Location: ./new_password.php");
            exit(); 
        } else {
            echo "Invalid OTP";
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
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
							<form method="POST" class="needs-validation" autocomplete="off">
								<div class="mb-3">

									<label for="opt" class="mb-2 text-muted">Enter OTP</label>
									<input class="form-control" id="otp" name="otp" placeholder="********" required autofocus>

								</div>

								<div class="d-flex align-items-center">
									<button type="submit" class="btn btn-primary ms-auto">
										Confirm	
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

	<script src="js/login.js"></script>
</body>
</html>