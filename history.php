<?php 
    include('./includes/config.php');
    $id = $_SESSION['account_id'];

    // Query with JOINs to fetch sender and recipient names along with transaction details
    $sql = "SELECT 
                t.transaction_date, 
                t.amount, 
                t.remarks,
                t.sender_account_id, 
                t.recipient_account_id,
                s.name AS sender_name,
                r.name AS recipient_name
            FROM transactions t
            LEFT JOIN user_info s ON t.sender_account_id = s.account_id
            LEFT JOIN user_info r ON t.recipient_account_id = r.account_id
            WHERE t.sender_account_id = ? OR t.recipient_account_id = ?";
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $id, $id);
    $stmt->execute();
    $result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./static/css/history.css">
</head>
<body>

    <?php include('./Partials/header.php')?>

    <div class="history-wrapper" style="margin-top: 50px;">
        <div class="history-container">
            <div class="history-header">Transaction History</div>

            <!-- Button Controls -->
            <div class="history-buttons">
                <button class="btn btn-history active-btn" id="sentBtn" onclick="showSent()">Sent</button>
                <button class="btn btn-history" id="receivedBtn" onclick="showReceived()">Received</button>
            </div>

            <!-- Sent Transactions Table -->
            <div id="sentTransactions">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Recipient</th>
                            <th>Amount</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Sent Transaction Data -->
                        <?php 
                            $sentFound = false;
                            // Loop through the results to display sent transactions
                            while ($row = $result->fetch_assoc()) {
                                if ($row['sender_account_id'] == $id) {
                                    $sentFound = true;
                                    // Display recipient's name if available; otherwise, fallback to account ID
                                    $recipient = !empty($row['recipient_name']) ? $row['recipient_name'] : $row['recipient_account_id'];
                                    echo '<tr>
                                            <td>' . $row['transaction_date'] . '</td>
                                            <td>' . $recipient . '</td>
                                            <td>' . $row['amount'] . '</td>
                                            <td>' . $row['remarks'] . '</td>
                                          </tr>';
                                }
                            }
                            if (!$sentFound) {
                                echo '<tr><td colspan="4">No sent transactions found</td></tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Received Transactions Table -->
            <div id="receivedTransactions" style="display: none;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Sender</th>
                            <th>Amount</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- To re-use the results, reset the pointer -->
                        <?php 
                            $receivedFound = false;
                            // Reset result pointer so we can loop through the data again
                            $result->data_seek(0);
                            while ($row = $result->fetch_assoc()) {
                                if ($row['recipient_account_id'] == $id) {
                                    $receivedFound = true;
                                    // Display sender's name if available; otherwise, fallback to account ID
                                    $sender = !empty($row['sender_name']) ? $row['sender_name'] : $row['sender_account_id'];
                                    echo '<tr>
                                            <td>' . $row['transaction_date'] . '</td>
                                            <td>' . $sender . '</td>
                                            <td>' . $row['amount'] . '</td>
                                            <td>' . $row['remarks'] . '</td>
                                          </tr>';
                                }
                            }
                            if (!$receivedFound) {
                                echo '<tr><td colspan="4">No received transactions found</td></tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="note">&copy; 2024 MyBank. Secure Transactions</div>
        </div>
    </div>

    <?php include('./Partials/footer.php')?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Function to show Sent Transactions and hide Received Transactions
        function showSent() {
            document.getElementById('sentTransactions').style.display = 'block';
            document.getElementById('receivedTransactions').style.display = 'none';
            document.getElementById('sentBtn').classList.add('active-btn');
            document.getElementById('receivedBtn').classList.remove('active-btn');
        }

        // Function to show Received Transactions and hide Sent Transactions
        function showReceived() {
            document.getElementById('sentTransactions').style.display = 'none';
            document.getElementById('receivedTransactions').style.display = 'block';
            document.getElementById('receivedBtn').classList.add('active-btn');
            document.getElementById('sentBtn').classList.remove('active-btn');
        }
    </script>
</body>
</html>
