<?php

session_start();

$now = time();
if ($now > $_SESSION['expire']) {
  unset($_SESSION['message']);
  unset($_SESSION['color']);
} else {
  $message = $_SESSION['message'];
  $color = $_SESSION['color'];
}

$loginID = $_SESSION['login_id'];

require_once('classes/crud.php');

$user = new CRUD;
$result = $user->getUser($loginID);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Kure Coffee</title>
  <!-- <link rel="icon" href="img/about.png"> -->
  <meta content="" name="descriptison">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="assets/vendor/venobox/venobox.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <style>
    #login {
      display: block;
      position: relative;
      color: white;
      transition: 0.3s;
      font-size: 14px;
      font-family: "Open Sans", sans-serif;
    }
    #login input, #login a {
      border: 2px solid #cda45e;
      color: #fff;
      border-radius: 50px;
      padding: 8px 25px;
      text-transform: uppercase;
      font-size: 13px;
      font-weight: 500;
      letter-spacing: 1px;
      transition: 0.3s;
    }
    #login input:hover, #login a:hover {
      background: #cda45e;
      color: #fff;
    }
    #online td {
      color: white;
    }
    .card p {
      margin-bottom: 0;
    }
  </style>
</head>

<body>

  <!-- ======= Top Bar ======= -->
  <div id="topbar" class="d-flex align-items-center fixed-top">
    <div class="container d-flex">
      <div class="contact-info mr-auto">
        <i class="icofont-phone"></i> +81 90 1234 5678
        <span class="d-none d-lg-inline-block"><i class="icofont-clock-time icofont-rotate-180"></i> Mon-Sat: 9:00 AM - 17:00 PM</span>
      </div>

      <p class="h5 text-warning m-2">
        <?php if (!empty($loginID)): ?>
          <?php if ($result['status'] == 'U'): ?>
            <a href="userProfile.php">
              Welcome: <?= $result['username'] ?>
            </a>
          <?php else: ?>
            <a href="dashboard.php">
              Go To Dashboard
            </a>
          <?php endif ?>
        <?php endif ?>
      </p>
    </div>
  </div>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">
      <?php if (empty($loginID)): ?>
        <h1 class="logo mr-auto"><a href="index.php">Kure Coffee</a></h1>
      <?php else: ?>
        <h1 class="logo mr-auto"><a href="indexForUser.php">Kure Coffee</a></h1>
      <?php endif ?>

      <nav class="nav-menu d-none d-lg-block">
        <ul>
          <li>
            <?php if (empty($loginID)): ?>
              <a href="index.php">Home</a>
            <?php else: ?>
              <a href="indexForUser.php">Home</a>
            <?php endif ?>
          </li>
          <!-- <li><a href="">About</a></li> -->
          <li><a href="onlineShopping.php">Online Shopping</a></li>
          <?php if (!empty($loginID)): ?>
            <li><a href="cart.php">Your Cart</a></li>
            <li><a href="history.php">Your Order</a></li>
            <!-- <li><a href="cart.php">Cart</a></li> -->
          <?php endif ?>
          <!-- <li><a href="">Contact</a></li> -->

          <?php
          if (empty($loginID)) {
            echo "<li class='book-a-table text-center'><a href='login.php'>Login</a></li>";
          } else {
            echo "<li class='book-a-table text-center'><a href='logout.php'>Logout</a></li>";
          }
          ?>

        </ul>
      </nav>
    </div>
  </header>