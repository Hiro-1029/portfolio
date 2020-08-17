<?php

session_start();

$loginID = $_SESSION['login_id'];
$now = time();
if ($now > $_SESSION['expire']) {
  unset($_SESSION['message']);
  unset($_SESSION['color']);
} else {
  $message = $_SESSION['message'];
  $color = $_SESSION['color'];
}

require_once('classes/crud.php');
require_once('classes/functions.php');

$user = new CRUD;
$result = $user->getUser($loginID);

$rowsForNew = $user->getItems('N');
$rowsForExist = $user->getItems('E');

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Kure Coffee</title>
  <meta content="" name="descriptison">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

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
    #payment tr {
      height: 40px;
    }
  </style>
</head>

<body>

  <!-- ======= Top Bar ======= -->
  <div id="topbar" class="d-flex align-items-center fixed-top">
    <div class="container d-flex">
      <div class="contact-info mr-auto">
        <i class="icofont-phone"></i> +1 5589 55488 55
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

      <h1 class="logo mr-auto"><a href="index.php">Kure Coffee</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <a href="index.php" class="logo mr-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>

      <nav class="nav-menu d-none d-lg-block">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="">About</a></li>
          <li><a href="onlineShopping.php">Online Shopping</a></li>
          <?php if (!empty($loginID)): ?>
            <li><a href="cartForMessage.php">Cart</a></li>
            <!-- <li><a href="cart.php">Cart</a></li> -->
          <?php endif ?>
          <li><a href="">Contact</a></li>
          
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