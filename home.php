<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head><script src="../assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.122.0">
    <title>Home</title>

    <link rel="icon" href="./static/img/img6.ico" type="image/x-icon">

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/carousel/">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Custom styles for this template -->
    <link href="./static/css/carousel.css" rel="stylesheet">

  </head>
  <body>
    
<?php include('./Partials/header.php')?>

<main>

  <div id="myCarousel" class="carousel slide mb-6" data-bs-ride="carousel">
    <div class="carousel-indicators">     
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="./static/img/img3.jpg" class="bd-placeholder-img" alt="Your description here" style="width: 100%; height: 100%; object-fit: cover;">
      <div class="container">
          <div class="carousel-caption text-start">
            <h1>Laxmi Chit Fund</h1>
            <p class="opacity-75" style="font-weight: bold;">Apply For Loan Easily</p>
            <p><a class="btn btn-lg btn-primary" href="./loan.php">Apply</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <img src="./static/img/img4.jpg" class="bd-placeholder-img" alt="Your description here" style="width: 100%; height: 100%; object-fit: cover">
      <div class="container">
          <div class="carousel-caption">
            <h1>Send money in seconds.</h1>
            <p style="font-weight: bold;">Transfers made easy, in seconds</p>
            <p><a class="btn btn-lg btn-primary" href="./transfer.php">Transfer</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <img src="./static/img/img5.jpg" class="bd-placeholder-img" alt="Your description here" style="width: 100%; height: 100%; object-fit: cover">
      <div class="container">
          <div class="carousel-caption text-end">
            <h1>Track every penny spent.</h1>
            <p style="font-weight: bold;">Check transaction history anytime.</p>
            <p><a class="btn btn-lg btn-primary" href="./history.php">View</a></p>
          </div>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>


  <div class="container marketing">

    <!-- Three columns of text below the carousel -->
    <div class="row" style="margin-top: 90px;">

      <div class="col-lg-4">
        <img src="./static/img/img7.jpg" width='140' height='140' viewBox='0 0 140 140' preserveAspectRatio='xMidYMid slice' role='img' aria-label='Placeholder'%3E%3Crect width='100%25' height='100%25' fill='var(--bs-secondary-color)'/%3E%3C/svg%3E" class="bd-placeholder-img rounded-circle" width="140" height="140" alt="Placeholder" style="object-fit: cover;">
        <h2 class="fw-normal">Transfer Money</h2>
        <p>Send money quickly and securely, anytime!</p>
        <p><a class="btn btn-secondary" href="./transfer.php">Transfer</a></p>
      </div><!-- /.col-lg-4 -->

      <div class="col-lg-4">
       <img src="./static/img/img8.jpg" width='140' height='140' viewBox='0 0 140 140' preserveAspectRatio='xMidYMid slice' role='img' aria-label='Placeholder'%3E%3Crect width='100%25' height='100%25' fill='var(--bs-secondary-color)'/%3E%3C/svg%3E" class="bd-placeholder-img rounded-circle" width="140" height="140" alt="Placeholder" style="object-fit: cover;">
        <h2 class="fw-normal">Loan</h2>
        <p>Apply for loans and track approval in real-time.</p>
        <p><a class="btn btn-secondary" href="./loan.php">Apply</a></p>
      </div><!-- /.col-lg-4 -->

      <div class="col-lg-4">
        <img src="./static/img/img9.jpg" width='140' height='140' viewBox='0 0 140 140' preserveAspectRatio='xMidYMid slice' role='img' aria-label='Placeholder'%3E%3Crect width='100%25' height='100%25' fill='var(--bs-secondary-color)'/%3E%3C/svg%3E" class="bd-placeholder-img rounded-circle" width="140" height="140" alt="Placeholder" style="object-fit: cover;">
        <h2 class="fw-normal">History</h2>
        <p>Track all your transactions with easy filters.</p>
        <p><a class="btn btn-secondary" href="./history.php">Check</a></p>
      </div><!-- /.col-lg-4 -->
    </div><!-- /.row -->


    <!-- START THE FEATURETTES -->

    <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7">
          <h2 class="featurette-heading fw-normal lh-1">Secure Transactions. <span class="text-body-secondary">Your money is safe with us.</span></h2>
          <p class="lead">We use state-of-the-art encryption and security protocols to ensure every transaction is safe and private.</p>
        </div>
        <div class="col-md-5"  style="border: 1px solid grey; border-radius: 10px;">
          <img src="./static/img/img10.jpg" class="featurette-image img-fluid mx-auto" alt="Secure Transactions">
        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7 order-md-2">
          <h2 class="featurette-heading fw-normal lh-1">Easy Money Transfers. <span class="text-body-secondary">Anytime, anywhere.</span></h2>
          <p class="lead">Transfer money instantly to your friends and family with a simple and user-friendly interface.</p>
        </div>
        <div class="col-md-5 order-md-1" style="border: 1px solid grey; border-radius: 10px;">
          <img src="./static/img/img4.jpg" class="featurette-image img-fluid mx-auto" alt="Easy Money Transfers">
        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette">
          <div class="col-md-7">
            <a href="./contact.php" style="text-decoration: none;">
              <h2 class="featurette-heading fw-normal lh-1" style="color: black;">24/7 Support. <span class="text-body-secondary">We're here for you.</span></h2>
            </a>
            <p class="lead">Need help? Our dedicated support team is available 24/7 to assist you with any queries or issues.</p>
          </div>
          <div class="col-md-5" style="border: 1px solid grey; border-radius: 10px;">
            <img src="./static/img/img11.jpg" class="featurette-image img-fluid mx-auto" alt="24/7 Support">
          </div>
      </div>

      <hr class="featurette-divider">
  </div>


  <!-- FOOTER -->
  <?php include('./Partials/footer.php')?>
</main>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="./static/js/dropdown.js"></script>


    </body>
</html>
