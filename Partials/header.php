<?php
    include('./includes/config.php');

    $account_id = $_SESSION['account_id'];
    $email = $_SESSION['email'];

    $sql = 'SELECT balance FROM user_info WHERE account_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $account_id);
    $stmt->execute();
    $stmt->bind_result($balance);

    $stmt->fetch();

?>


<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head><script src="../assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.122.0">
    <title>Carousel Template · Bootstrap v5.3</title>

    <link rel="icon" href="../static/img/img6.ico" type="image/x-icon">

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/carousel/">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Custom styles for this template -->
    <link href="./static/css/footer.css" rel="stylesheet">
    <link href="./static/css/home.css" rel="stylesheet">

  </head>
  <body>
    
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow fixed-top" >
  <div class="container-fluid" >
    <!-- Brand -->
    <a class="navbar-brand" href="./home.php">
      <img src="./static/img/img6.jpg" alt="Your description here" class="bd-placeholder-img" style="width: 30px; height: 30px; object-fit: cover; border-radius: 50px;">
    </a>

    <!-- Toggler for Hamburger Menu -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar Content -->
    <div class="collapse navbar-collapse" id="navbarContent">
      <!-- Right Side Content -->
      <ul class="navbar-nav ms-auto">
          <li class="nav-item">
          <?php 
                echo '<span class="nav-link text-light">Balance: Rs ' . number_format($balance, 2) . '</span>';              
            ?>
          </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-light" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person text-light" viewBox="0 0 16 16">
              <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
            </svg>
          </a>
          <ul class="dropdown-menu dropdown-menu-end bg-dark custom-dropdown" aria-labelledby="profileDropdown">
            <li><a class="dropdown-item" href="./home.php">Home</a></li>
            <li><a class="dropdown-item" href="./profile.php">Profile</a></li>
            <li><a class="dropdown-item" href="./contact.php">Contact</a></li>
            <li><a class="dropdown-item" href="./history.php">History</a></li>
            <li><a class="dropdown-item" href="./reset.php">Reset Password</a></li>
            <li><hr class="dropdown-divider text-white"></li>
            <li><a class="dropdown-item text-danger" href="./logout.php">Log Out</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>