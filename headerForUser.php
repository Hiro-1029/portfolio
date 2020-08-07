<?php

session_start();
$loginID = $_SESSION['login_id'];
$messages[] = $_SESSION['message'];
$color = $_SESSION['color'];

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

  </style>
  <!-- =======================================================
  * Template Name: Restaurantly - v1.1.0
  * Template URL: https://bootstrapmade.com/restaurantly-restaurant-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
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
            <a href="user.php">
              Welcome: <?= $result['username'] ?>
            </a>
          <?php elseif ($result['status'] == 'A'): ?>
            <a href="adminUser.php">
              Welcome Admin: <?= $result['username'] ?>
            </a>
          <?php else: ?>
            <a href="superAdmin.php">
              Welcome Super Admin: <?= $result['username'] ?>
            </a>
          <?php endif ?>
        <?php endif ?>
      </p>
      <!-- <div class="languages">
        <ul>
          <li><a href="#">English</a></li>
          <li><a href="#">Japanese</a></li>
        </ul>
      </div> -->
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
          <li class="active"><a href="index.php">Home</a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#menu">Menu</a></li>
          <li><a href="#shopping">Online Shopping</a></li>
          <li><a href="#cart">Cart</a></li>
          <li><a href="#contact">Contact</a></li>

          <?php
          if (!empty($loginID)) {
            echo "<li class='book-a-table text-center'><a href='logout.php'>Logout</a></li>";
          } else {
            echo "<li class='book-a-table text-center'><a href='login.php'>Login</a></li>";
          }
          ?>

        </ul>
      </nav><!-- .nav-menu -->

    </div>
  </header><!-- End Header -->