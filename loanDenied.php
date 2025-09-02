<?php
include('./includes/config.php');

// Initialize the message variable
$message = "";
$remaining_time = "";

// Ensure session variables are set before using them
if ($_SESSION['account_id']) {
    $date = $_SESSION['date'];
    $account_id = $_SESSION['account_id'];


    // Use prepared statements to prevent SQL injection
    $sql = "SELECT Loan_Status, loan_date FROM loandetails WHERE account_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $account_id); // 's' for string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Calculate the date one month after the loan application
        $after_one_month = date('Y-m-d', strtotime($row["loan_date"] . ' + 1 month'));

        // Check if the date is exactly one month after the loan application
        if ($after_one_month === $row["loan_date"]) {
            // Delete data from loandetails where account_id matches
            $delete_sql = "DELETE FROM loandetails WHERE account_id = ?";
            $delete_stmt = $conn->prepare($delete_sql);
            $delete_stmt->bind_param('s', $account_id);
            $delete_stmt->execute();

            // Provide a success message if deletion is successful
            $message = "Loan details deleted successfully.";
        } else {
            // Calculate the time remaining
            $current_date = new DateTime();
            $due_date = new DateTime($after_one_month);
            $interval = $current_date->diff($due_date);

            if ($interval->invert == 0) {
                $remaining_time = "Time remaining: " . $interval->format('%d days, %h hours, %i minutes');
                $message = "Your Loan is Denied" . "<br>" . "Please wait until the one-month period has passed.";
            } else {
                $remaining_time = "The one-month period has passed!";
                $message = "You can now proceed with your next loan action.";
            }
        }
    } else {
        // If no records are found for the account_id
        $message = "No loan record found.";
    }
} else {
    $message = "Session variables are not set properly.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4 d-flex justify-content-center align-items-center" style="height: 100vh;">
    <!-- Center the message in a div -->
    <?php
    if ($message != "") {
        echo "<div class='alert alert-info text-center'>" . $message . "<br>" . $remaining_time . "</div>";
    }
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
