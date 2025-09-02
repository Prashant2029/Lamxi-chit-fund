<?php 
    include('./includes/config.php');

    $modalMessage = ''; // Variable to store the modal message
    $modalTitle = ''; // Variable to store the modal title
    $modalClass = ''; // Variable to store the modal class for background color (e.g., success or error)

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $receivers_id = $_POST['receiverId'];
        $amount = $_POST['sentAmount'];
        $remark = $_POST['message'];
        $date = date("Y-m-d");

        $senders_id = $_SESSION['account_id'];

        // Validate if sender and receiver are the same
        if ($senders_id == $receivers_id) {
            $modalMessage = "You cannot transfer money to the same account.";
            $modalTitle = "Transfer Error";
            $modalClass = "danger";
        }
        // Validate if the amount is less than 10
        elseif ($amount < 10) {
            $modalMessage = "Minimum transfer amount is 10.";
            $modalTitle = "Transfer Error";
            $modalClass = "danger";
        }
        // Check if receiver ID exists in the database
        else {
            $sql = "SELECT account_id FROM user_info WHERE account_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $receivers_id);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows == 0) {
                $modalMessage = "Receiver ID not found.";
                $modalTitle = "Transfer Error";
                $modalClass = "danger";
                $stmt->close();
            } else {
                $stmt->close();

                // Check if the sender has enough balance
                $sql = "SELECT balance FROM user_info WHERE account_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $senders_id);
                $stmt->execute();
                $stmt->bind_result($balance);
                $stmt->fetch();
                $stmt->close();

                if ($amount > $balance) {
                    $modalMessage = "Insufficient balance to transfer the specified amount.";
                    $modalTitle = "Transfer Error";
                    $modalClass = "danger";
                } else {
                    // Update receiver's balance
                    $sql =  'UPDATE user_info SET balance = balance + ? WHERE account_id = ?';
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ii", $amount, $receivers_id);
                    $stmt->execute();
                    $stmt->close();

                    // Update sender's balance
                    $sql =  'UPDATE user_info SET balance = balance - ? WHERE account_id = ?';
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ii", $amount, $senders_id);
                    $stmt->execute();
                    $stmt->close();

                    // Insert transaction into history
                    $sql = "INSERT INTO transactions (sender_account_id, recipient_account_id , amount, remarks, transaction_date) VALUES (?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("iiiss", $senders_id, $receivers_id, $amount, $remark, $date);
                    $stmt->execute();
                    $stmt->close();

                    $modalMessage = "Balance Transferred Successfully";
                    $modalTitle = "Success";
                    $modalClass = "success";
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer</title>
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
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .transfer-wrapper {
            padding: 40px 15px;
            background: #f7fafc;
            flex: 1;
        }

        .transfer-container {
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

        <div class="transfer-wrapper d-flex justify-content-center align-items-center" style="min-height: 10vh;">
            <div class="transfer-container" style="max-width: 500px; width: 100%;">
                <div class="loan-header text-center">Transfer</div>
                <form id="loanForm" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <div class="form-group">
                        <label for="Receiver-id">Receiver Id</label>
                        <input type="text" name="receiverId" id="Receiver-id" class="form-control" placeholder="Account Id" pattern="\d+" title="Enter valid id" required>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="text" name="sentAmount" id="amount" class="form-control" placeholder="Enter amount" pattern="\d+" title="Enter valid amount" required>
                    </div>
                    <div class="form-group">
                        <label for="remarks">Remarks</label>
                        <textarea id="remarks" name="message" class="form-control" placeholder="Remarks" style="resize: none;" required></textarea>
                    </div>
                                
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">Transfer</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="statusModalLabel"><?php echo $modalTitle; ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-<?php echo $modalClass; ?>"><?php echo $modalMessage; ?></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


    <?php include('./Partials/footer.php'); ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <?php if ($modalMessage != ''): ?>
        <script>
            var myModal = new bootstrap.Modal(document.getElementById('statusModal'), {
                keyboard: false
            });
            myModal.show();
        </script>
    <?php endif; ?>
</body>
</html>
