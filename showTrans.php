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
$resultForTrans = $user->getTrans('I');
$resultForCompTrans = $user->getTrans('S');

if ($result['status'] == 'U' || empty($loginID)) {
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
</style>
</head>
<body>

  <?php include('parts/navbar.php') ?>

  <main class="my-5">

    <?php if (!empty($message)): ?>
      <?= "<p class='pt-4 $color text-center' style='font-size: 20px;'>$message</p>" ?>
    <?php endif ?>

    <!-- show transactions in process -->
    <div class="container-fluid row justify-content-center m-0">
      <div class="col d-flex align-items-center text-dark" style="height:3rem;">
        <i class="fas fa-edit" ></i> Orders in process
      </div>

      <table class="table table-striped table-hover">
        <thead class="thead-dark">
          <tr>
            <th>Transaction ID</th>
            <th>Login ID</th>
            <th>Total Payment</th>
            <th>Transaction Date</th>
            <th></th>
          </tr>
        </thead>

        <?php foreach ($resultForTrans as $row): ?>
          <tr>
            <td class="align-middle"><?= $row['tran_id'] ?></td>
            <td class="align-middle"><?= $row['login_id'] ?></td>
            <td class="align-middle">USD <?= $row['total_pay'] ?></td>
            <td class="align-middle"><?= $row['tran_date'] ?></td>
            <td>
              <form action="showTranDetail.php" method="post">
                <input type="hidden" name="tranID" value="<?= $row['tran_id'] ?>">
                <input type="hidden" name="loginID" value="<?= $row['login_id'] ?>">
                <button type="submit" name="detail" class="btn btn-outline-dark">&raquo Details</button>
              </form>
            </td>
          </tr>
        <?php endforeach ?>
      </table>
    </div>

    <!-- show completed transactions -->
    <div class="container-fluid row justify-content-center m-0">

      <div class="col d-flex align-items-center text-dark" style="height:3rem;">
        <i class="fas fa-edit" ></i> Orders completed
      </div>

      <table class="table table-striped table-hover">
        <thead class="thead-dark">
          <tr>
            <th>Transaction ID</th>
            <th>Login ID</th>
            <th>Total Payment</th>
            <th>Transaction Date</th>
            <th></th>
          </tr>
        </thead>

        <?php foreach ($resultForCompTrans as $row): ?>
          <tr>
            <td class="align-middle"><?= $row['tran_id'] ?></td>
            <td class="align-middle"><?= $row['login_id'] ?></td>
            <td class="align-middle">USD <?= $row['total_pay'] ?></td>
            <td class="align-middle"><?= $row['tran_date'] ?></td>
            <td>
              <form action="showTranDetail.php" method="post">
                <input type="hidden" name="tranID" value="<?= $row['tran_id'] ?>">
                <input type="hidden" name="loginID" value="<?= $row['login_id'] ?>">
                <button type="submit" name="detail" class="btn btn-outline-dark">&raquo Details</button>
              </form>
            </td>
          </tr>
        <?php endforeach ?>
      </table>
    </div>



  </main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>