<?php 
    include('./includes/config.php');
    
    $account_id = $_SESSION['account_id'];


    $sql = 'SELECT email, name, phone, address, account_id FROM user_info WHERE account_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $account_id);
    $stmt->execute();
    $stmt->bind_result($email, $name, $phone, $address, $account_id);
    $stmt->fetch();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./static/css/pro">
    <style>
        body {
            background-color: #f4f7fc;
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
        }

        .profile-wrapper {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .profile-container {
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 10px 6px 20px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            text-align: center;
            border-color: #333;
            border-style: inset;
        }

        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin: 0 auto 20px;
            border: 3px solid #3182ce;
            object-fit: cover;
        }

        .profile-header {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: #333;
        }

        .profile-subtitle {
            font-size: 1rem;
            font-weight: 400;
            color: #777;
            margin-bottom: 20px;
        }

        .profile-info {
            text-align: left;
            margin-top: 20px;
        }

        .profile-info h5 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #555;
            margin-bottom: 10px;
        }

        .profile-info p {
            font-size: 1rem;
            color: #777;
            margin-bottom: 15px;
        }

        .note {
            text-align: center;
            margin-top: 20px;
            font-size: 0.85rem;
            color: #888;
        }
    </style>
</head>
<body>
  <?php include('./Partials/header.php')?>

    <div class="profile-wrapper" style="margin-bottom: 20px; margin-top: 30px;">
        <div class="profile-container">

            <?php 
            // <!-- Profile Name and Subtitle -->
            echo '<div class="profile-header">' . ucwords($name) . '</div>';
            echo '<div class="profile-subtitle"> Account Id: ' , $account_id . '</div>';

            // <!-- Profile Details -->
            echo '<div class="profile-info">';
                
            
                
                echo '<h5>Email Address</h5>';
                echo '<p>' . $email . '</p>';

                echo '<h5>Phone Number</h5>';
                echo '<p>' . htmlspecialchars($phone) . '</p>';

                echo '<h5>Address</h5>';
                echo '<p>' . htmlspecialchars($address) . '</p>';

                echo '<h5>Account Type</h5>';
                echo '<p>Savings Account</p>';

                echo '<h5>Branch</h5>';
                echo '<p>Bhaktapur Branch</p>';
                
            ?>
            </div>

            <!-- Footer Note -->
            <div class="note">© 2024 Laxmi cheat fund. All rights reserved.</div>
        </div>
    </div>

    <?php include('./Partials/footer.php')?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
