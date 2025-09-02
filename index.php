<?php
include('./includes/config.php');

$modalMessage = ''; 
$modalTitle = ''; 
$modalClass = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start(); // Start the session at the top

    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    try {
        $sql = "SELECT * FROM user_info WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

    } catch (Exception $e) {
        error_log($e->getMessage());
        $modalMessage = "Login Failed. Please try again.";
        $modalTitle = "Login Failed";
        $modalClass = "danger";
        exit;
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password']; // Retrieve the stored hash

        if (password_verify($password, $hashed_password)) {
            session_regenerate_id(true); // Secure session
            $_SESSION['account_id'] = $row['account_id'];
            $_SESSION['email'] = $row['email'];

			header("Location: ./home.php");
        } else {
            $modalMessage = "Credentials do not match.";
            $modalTitle = "Login Failed";
            $modalClass = "danger";
        }
    } else {
        $modalMessage = "Account not found.";
        $modalTitle = "Login Failed";
        $modalClass = "danger";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Muhamad Nauval Azhar">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="This is a login page template based on Bootstrap 5">
    <title>Login</title>
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
                            <h1 class="fs-4 card-title fw-bold mb-4">Login</h1>
                            <form method="POST" class="needs-validation" novalidate="" autocomplete="off">
                                <div class="mb-3">
                                    <label class="mb-2 text-muted" for="email">E-Mail Address</label>
                                    <input id="email" type="email" class="form-control" name="email" value="" required autofocus>
                                    <div class="invalid-feedback">
                                        Email is invalid
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="mb-2 w-100">
                                        <label class="text-muted" for="password">Password</label>
                                        <a href="./forgot.php" class="float-end">
                                            Forgot Password?
                                        </a>
                                    </div>
                                    <input id="password" type="password" class="form-control" name="password" required>
                                    <div class="invalid-feedback">
                                        Password is required
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-center">
                                    <button type="submit" class="btn btn-primary">
                                        Login
                                    </button>
                                </div>

                            </form>
                        </div>
                        <div class="card-footer py-3 border-0">
                            <div class="text-center">
                                Don't have an account? <a href="./register.php" class="text-dark">Create One</a>
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

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel"><?php echo $modalTitle; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php echo $modalMessage; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-<?php echo $modalClass; ?>" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <?php if ($modalMessage != ''): ?>
        <script>
            var myModal = new bootstrap.Modal(document.getElementById('successModal'), {
                keyboard: false
            });
            myModal.show();
        </script>
    <?php endif; ?>

</body>
</html>
