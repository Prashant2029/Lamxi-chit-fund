<?php
include('./includes/config.php');

$message = null; // Default value

if (isset($_SESSION['account_id'])) {
    $account_id = $_SESSION['account_id'];

    // Check if account ID already exists in the LoanDetails table
    $sql = 'SELECT Account_ID, Loan_Status FROM loandetails WHERE Account_ID = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $account_id);
    $stmt->execute();
    $stmt->store_result(); // Store result for checking
    $stmt->bind_result($fetched_account_id, $fetched_status);


    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        $status = $fetched_status;
        // Account already has a loan application
        $message = "Your loan application has been $status.";
    } else {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $full_name = $_POST['fullName'];
            $date = new DateTime();
            $formatted_date = $date->format('Y-m-d');

            $_SESSION['date'] = $formatted_date;

            $data = array(
                (int) $_POST['dependents'],
                $_POST['education'],
                $_POST['employment'],   
                (int) $_POST['annualIncome'],
                (int) $_POST['loanAmount'],
                (int) $_POST['loanTerm'],
                (int) $_POST['cibil'],
                (int) $_POST['residentalValue'],
                (int) $_POST['commercialValue'],
                (int) $_POST['luxuryValue'],
                (int) $_POST['bankValue']
            );
            
            $json_data = json_encode(array('input' => $data));
            
            // Initialize cURL session to call the Python API
            $ch = curl_init('http://localhost:5000/predict');  // Adjust URL if needed

            // Set cURL options
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($json_data)
            ));


            // Execute cURL request and get the response
            $response = curl_exec($ch);


            // Close cURL session
            curl_close($ch);


            // Decode the JSON response from Python API
            $response_data = json_decode($response, true);


            // Check if the approval key exists and handle the prediction result
            if (isset($response_data['approval'])) {
                $approval = $response_data['approval'];  // Either 1 (approved) or 0 (denied)

                $status = $approval == 1 ? "Approved" : "Denied";

                $_SESSION['status'] = $status;
            } else {
                echo '<div class="alert alert-danger" role="alert">';
                echo "Error: Approval data not found in response.";
                echo '</div>';
            }            

            $sql = 'INSERT INTO loandetails 
                    (Account_ID, Name, No_of_Dependents, Education, Self_Employed, Income_Annum, Loan_Amount, Loan_Term, Cibil_Score, Residential_Assets_Value, Commercial_Assets_Value, Luxury_Assets_Value, Bank_Asset_Value, Loan_Status, loan_date) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                die("Error preparing statement: " . $conn->error);
            }

            // Bind parameters using correct types
            $stmt->bind_param('isissddiiddddss', $account_id, $full_name, $data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8], $data[9], $data[10], $status, $formatted_date);

            if ($stmt->execute()) {
                $message = "Your loan application has been $status.";
            } else {
                $message = "Error: Approval data not found in response.";
            }

            $stmt->close();
            $conn->close();


        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Application</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7fafc;
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .content-wrapper {
            flex: 1; /* Ensures content stretches but footer stays at the bottom */
            display: flex;
            flex-direction: column;
        }

        .loan-wrapper {
            padding: 40px 15px;
            background: #f7fafc;
            flex: 1;
        }

        .loan-container {
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            max-width: 800px;
            margin: 0 auto;
        }

        .loan-header {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-align: center;
            color: #2d3748;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: 600;
            color: #2d3748;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #e2e8f0;
        }

        .form-group textarea {
            height: 150px;
        }

        .btn-submit {
            background-color: #3182ce;
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 1rem;
            cursor: pointer;
            border-radius: 5px;
            font-weight: 600;
        }

        .btn-submit:hover {
            background-color: #2b6cb0;
        }

        .note {
            text-align: center;
            margin-top: 20px;
            font-size: 0.85rem;
            color: #a0aec0;
        }

        .status-message {
            margin-top: 20px;
            font-weight: 600;
            font-size: 1.1rem;
            color: #2d3748;
            text-align: center;
        }

        footer {
            background-color: #343a40;
            color: #f8f9fa;
            padding: 20px 0;
        }

    </style>
</head>
<body>
    <div class="content-wrapper">
        <?php include('./Partials/header.php'); ?>


        <?php if (isset($message)) : ?>

            <?php if ($status == "Approved") : ?>
                <div class="d-flex justify-content-center align-items-center vh-100">
                    <div class="alert alert-success w-50 text-center">
                        <?php echo "Your loan is approved.<br>For more inquiries, visit the nearest branch."; ?>
                    </div>
                </div>

            <?php else : ?>
                <?php include("./loanDenied.php"); ?>
            <?php endif; ?>


        <?php else:  ?>

            <div class="loan-wrapper">
                <div class="loan-container">
                    <div class="loan-header">Loan Application</div>
                    <form id="loanForm" method = "POST">
                        <div class="form-group">
                            <label for="fullName">Full Name</label>
                            <input type="text" id="fullName" class="form-control" placeholder="Enter your full name" name = "fullName" required>
                        </div>
                        <div class="form-group">
                            <label for="dependents">No of Dependents</label>
                            <input type="text" id="dependents" class="form-control" name="dependents" pattern="[0-9]+" placeholder="Number of Dependents" required>
                        </div>
                        <div class="form-group">
                            <label for="loanAmount">Loan Amount</label>
                            <input type="number" id="loanAmount" class="form-control" placeholder="Enter loan amount" name="loanAmount" required min="1000">
                        </div>
                        <div class="form-group">
                            <label for="annualIncome">Annual Income</label>
                            <input type="number" id="annualIncome" class="form-control" placeholder="Enter Annual Income" name="annualIncome" required min="1000">
                        </div>
                        <div class="form-group">
                            <label for="education">Education</label>
                            <select id="education" class="form-control" name = "education" required>
                                <option value="Not Graduate">Not Graduate</option>
                                <option value="Graduate">Graduate</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="employment">Employed</label>
                            <select id="employment" class="form-control" name = "employment" required>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="loanTerm">Loan Term (months)</label>
                            <select id="loanTerm" class="form-control" name = "loanTerm" required>
                                <option value="12">12 months</option>
                                <option value="24">24 months</option>
                                <option value="36">36 months</option>
                                <option value="48">48 months</option>
                                <option value="60">60 months</option>
                            </select>
                        </div>
                        <div class="form-group">
                        <label for="cibil">CIBIL Score:</label>
                        <input type="number" id="cibil" name="cibil" pattern="[0-9]+" min="300" max="900" required placeholder="Enter your CIBIL score">
                        </div>
                        <div class="form-group">
                            <label for="residentalValue">Residental Assets Value</label>
                            <input type="number" id="residentalValue" class="form-control" name = "residentalValue" placeholder="Enter your Residental Asset Value" required min="10000">
                        </div>
                        <div class="form-group">
                            <label for="commercialValue">Commercial Assets Value</label>
                            <input type="number" id="commercialValue" class="form-control" name = "commercialValue" placeholder="Enter your Commercial Assets Value" required min="10000">
                        </div>
                        <div class="form-group">
                            <label for="luxuryValue">Luxury Assets Value Income</label>
                            <input type="number" id="luxuryValue" class="form-control" name = "luxuryValue" placeholder="Enter your Luxury Assets Value" required min="10000">
                        </div>
                        <div class="form-group">
                            <label for="bankValue">Bank Asseets Value</label>
                            <input type="number" id="bankValue" class="form-control" name = "bankValue" placeholder="Enter your Bank Asset Value" required min="10000">
                        </div>
                        <button type="submit" class="btn-submit">Submit Application</button>
                    </form>
                    <div id="statusMessage" class="status-message" style="display: none;"></div>
                </div>
            </div>

        <?php endif; ?>

    </div> 

    <footer class="bg-dark text-light py-4">
        <div class="container">
            <div class="row">
                <!-- About Section -->
                <div class="col-md-4">
                    <h5>About Us</h5>
                    <p>A banking app allows secure account management, transfers, bill payments, and budgeting.<p>
                </div>
            <!-- Links Section -->
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light text-decoration-none">Home</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Services</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Contact</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Privacy Policy</a></li>
                    </ul>
                </div>
                <!-- Contact Section -->
                <div class="col-md-4">
                    <h5>Contact Us</h5>
                    <p>Email: support@example.com</p>
                    <p>Phone: +123 456 7890</p>
                    <p>Address: 123 Main St, City, Country</p>
                </div>
            </div>
            <hr class="border-light">
            <div class="text-center">
                <p class="mb-0">© 2024 Laxmi cheat fund. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src = "./static/js/cancelLoan.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>