<?php
    include('./includes/config.php');



    $showModal = false; // Flag to show the modal

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT); 
        $phone = htmlspecialchars($_POST['phone']);
        $address = htmlspecialchars($_POST['address']);

        function generateUniqueAccountId($conn) {
            do {
                $accountId = rand(10000000, 99999999);
        
                $query = $conn->prepare("SELECT COUNT(*) FROM user_info WHERE account_id = ? OR email = ?");
                $query->bind_param("is", $accountId, $email);
                $query->execute();
                $query->bind_result($count);
                $query->fetch();
                $query->close();
        
            } while ($count > 0); 
        
            return $accountId;
        }

        $accountId = generateUniqueAccountId($conn);

        $sql = "INSERT INTO user_info (name, email, password, phone, address, account_id) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $name, $email, $password, $phone, $address, $accountId);

        if ($stmt->execute()) {
            // Success, set the flag to show the modal
            $showModal = true;
			$account_id = $accountId;
        } else {
            // Error message
            echo '
                <div class="alert alert-danger" role="alert">
                    Error: ' . $stmt->error . '
                </div>
            ';
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
    <title>Register</title>
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
                            <h1 class="fs-4 card-title fw-bold mb-4">Register</h1>
                            <form method="POST" class="needs-validation" autocomplete="off">
                                <div class="mb-3">
                                    <label class="mb-2 text-muted" for="name">Name</label>
                                    <input id="name" type="text" class="form-control" name="name" value="" required autofocus>
                                    <div class="invalid-feedback">
                                        Name is required    
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="mb-2 text-muted" for="email">E-Mail Address</label>
                                    <input id="email" type="email" class="form-control" name="email" required>
                                    <div class="invalid-feedback">
                                        Email is invalid
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="mb-2 text-muted" for="password">Password</label>
                                    <input id="password" type="password" class="form-control" name="password" required>
                                    <div class="invalid-feedback">
                                        Password is required
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="mb-2 text-muted" for="phone">Phone</label>
                                    <input id="phone" type="text" pattern="\d+" class="form-control" name="phone" required>
                                    <div class="invalid-feedback">
                                        Phone Number is required
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="mb-2 text-muted" for="address">Address</label>
                                    <input id="address" type="text" class="form-control" name="address" required>
                                    <div class="invalid-feedback">
                                        Address is required
                                    </div>
                                </div>

                                <p class="form-text text-muted mb-3">
                                    By registering you agree with our terms and condition.
                                </p>

                                <div class="d-flex align-items-center justify-content-center">
                                    <button type="submit" class="btn btn-primary">
                                        Register
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer py-3 border-0">
                            <div class="text-center">
                                Already have an account? <a href="./index.php" class="text-dark">Login</a>
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
                    <h5 class="modal-title" id="successModalLabel">Registration Successful</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    You have successfully registered! You will be redirected to the login page shortly.<br>
					Your account id is: <?php echo $account_id; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="window.location.href='./index.php'">
                        Go to Login
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js"></script>

    <script>
        // Show modal if registration is successful
        <?php if ($showModal): ?>
            var myModal = new bootstrap.Modal(document.getElementById('successModal'), {
                keyboard: false
            });
            myModal.show();
        <?php endif; ?>
    </script>
</body>
</html>
