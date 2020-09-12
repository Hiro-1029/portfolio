<?php

session_start();

require_once('classes/crud.php');

$loginID = $_SESSION['login_id'];
$now = time();
if ($now > $_SESSION['expire']) {
  unset($_SESSION['message']);
  unset($_SESSION['color']);
} else {
  $message = $_SESSION['message'];
  $color = $_SESSION['color'];
}

$user = new CRUD;
$result = $user->getUser($loginID);
$rowsNotSold = $user->getItemsNotSold();

if ($result['status'] == 'U' || $result['status'] == 'R' ||empty($loginID)) {
  header("location: logout.php");
  exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="Description" content="Enter your description here"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
<link rel="stylesheet" href="assets/css/style.css">
<title>Users</title>
<style>
  body {
    background-color: white;
  }
  #best, #worst, #topSales, #worstSales {
    display: block;
    padding-top: 75px;
    margin-top: -75px;
}
</style>
</head>
<body>

  <?php include('parts/navbar.php') ?>

  <div class="container text-dark h4" style="margin-top:75px !important;">
    <ol>
      <li><a href="#best">Orders Top</a></li>
      <li><a href="#topSales">Sales Top</a></li>
      <li><a href="#worst">Orders Worst</a></li>
      <li><a href="#worstSales">Sales Worst</a></li>
    </ol>
  </div>

  <!-- show higher order items -->
  <div id="best" class="container my-3">
    <div class="input-group">
      <p class="text-muted h4 pr-3 mb-0 align-self-center">1. Please input a number to see top orders ranking &rarr; </p>
      <form action="#best" method="post" class="form-inline">
        <input type="number" min="0" name="top" class="form-control form-inline mr-2" style="width:100px;">
        <button type="submit" name="itemPop" class="btn form-control ml-auto text-white" style="background-color:#cda45e; width:100px;">Search</button>
      </form>
    </div>
  </div>
  <?php 
    if (isset($_POST['itemPop'])) {
      $top = $_POST['top'];
      $rows = $user->getItemsBest($top);

      showPop($top, $rows, $rowsNotSold, 'O');
       
    } else {
      $rows = $user->getItemsBest(5);

      showPop(5, $rows, $rowsNotSold, 'O');
    }
  ?>

  <!-- show higher sales items -->
  <div id="topSales" class="container my-3">
    <div class="input-group">
      <p class="text-muted h4 pr-3 mb-0 align-self-center">2. Please input a number to see top sales ranking &rarr; </p>
      <form action="#topSales" method="post" class="form-inline">
        <input type="number" min="0" name="topSales" class="form-control form-inline mr-2" style="width:100px;">
        <button type="submit" name="itemTopSales" class="btn form-control ml-auto text-white" style="background-color:#cda45e; width:100px;">Search</button>
      </form>
    </div>
  </div>
  <?php 
    if (isset($_POST['itemTopSales'])) {
      $top = $_POST['topSales'];
      $rows = $user->getItemsTopSales($top);

      showPop($top, $rows, $rowsNotSold, 'S');
       
    } else {
      $rows = $user->getItemsTopSales(5);

      showPop(5, $rows, $rowsNotSold, 'S');
    }
  ?>

  <!-- show lower order items -->
  <div id="worst" class="container my-3">
    <div class="input-group">
      <p class="text-muted h4 pr-3 mb-0 align-self-center">3. Please input a number to see top ranking &rarr; </p>
      <form action="#worst" method="post" class="form-inline">
        <input type="number" min="0" name="worst" class="form-control form-inline mr-2" style="width:100px;">
        <button type="submit" name="itemWorst" class="btn form-control ml-auto text-white" style="background-color:#cda45e; width:100px;">Search</button>
      </form>
    </div>
  </div>
  <?php 
    if (isset($_POST['itemWorst'])) {
      $worst = $_POST['worst'];
      $rows = $user->getItemsWorst($worst);

      showUnpop($worst, $rows, $rowsNotSold, 'O');
      
    } else {
      $rows = $user->getItemsWorst(5);

      showUnpop(5, $rows, $rowsNotSold, 'O');
    }
  ?>

  <!-- show lower sales items -->
  <div id="worstSales" class="container my-3">
    <div class="input-group">
      <p class="text-muted h4 pr-3 mb-0 align-self-center">4. Please input a number to see top ranking &rarr; </p>
      <form action="#worstSales" method="post" class="form-inline">
        <input type="number" min="0" name="worstSales" class="form-control form-inline mr-2" style="width:100px;">
        <button type="submit" name="itemWorstSales" class="btn form-control ml-auto text-white" style="background-color:#cda45e; width:100px;">Search</button>
      </form>
    </div>
  </div>
  <?php 
    if (isset($_POST['itemWorstSales'])) {
      $worst = $_POST['worstSales'];
      $rows = $user->getItemsWorstSales($worst);

      showUnpop($worst, $rows, $rowsNotSold, 'S');
      
    } else {
      $rows = $user->getItemsWorstSales(5);

      showUnpop(5, $rows, $rowsNotSold, 'S');
    }
  ?>
  
      
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>