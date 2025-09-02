<?php
include('./includes/config.php');
   

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['name'], $_POST['email'], $_POST['assist'], $_POST['message'])) {

        $account_id = $_SESSION['account_id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $assist = $_POST['assist'];
        $message = $_POST['message'];

        $sql = 'INSERT INTO contactus (account_id, name, email, assist, message) VALUES (?, ?, ?, ?, ?)';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('issss', $account_id, $name, $email, $assist, $message);

        if ($stmt->execute()) {
            // Redirect after successful submission to avoid resubmission on page refresh
            echo"
                    <script>
                        alert('Message Sent Successfully');
                        window.location.href = 'contact.php';
                    </script>
                    ";
            
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Please fill in all required fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - 24/7 Support</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include('./Partials/header.php')?> 

<!-- Header Section -->
<header class="bg-primary text-white text-center py-5" style="margin-top: 20px;">
    <h1>Contact Us</h1>
    <p class="lead">24/7 Support. We're here for you.</p>
    <p>Need help? Our dedicated support team is available 24/7 to assist you with any queries or issues.</p>
</header>

<!-- Main Contact Section -->
<div class="container my-5">
    <div class="row align-items-center">
        <!-- Contact Form -->
        <div class="col-lg-6 mb-4">
            <h3 class="mb-4">Reach Out to Us</h3>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="mb-3">
                    <label for="query" class="form-label">How can we assist you?</label>
                    <select class="form-select" id="query" name="assist">
                        <option value="support" selected>Support</option>
                        <option value="billing">Billing</option>
                        <option value="technical">Technical Issues</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Your Message</label>
                    <textarea class="form-control" name="message" id="message" rows="4" style="resize: none;" placeholder="Describe your issue or question"></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">Submit</button>
            </form>
        </div>

        <!-- Contact Info -->
        <div class="col-lg-6">
            <h3 class="mb-4">Contact Information</h3>
            <div class="card p-3 shadow">
                <h5 class="card-title">We're Here 24/7</h5>
                <p class="card-text">No matter the time, feel free to reach out to us through the following:</p>
                <ul class="list-unstyled">
                    <li><strong>Email:</strong> support@example.com</li>
                    <li><strong>Phone:</strong> +1 (123) 456-7890</li>
                    <li><strong>Live Chat:</strong> Available on our website</li>
                </ul>
                <p class="text-muted">Response time may vary depending on the query, but we're committed to responding promptly.</p>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include('./Partials/footer.php')?> 

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
