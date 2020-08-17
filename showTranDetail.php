<?php

session_start();

require_once('classes/crud.php');

$loginID = $_SESSION['login_id'];
$_SESSION['message'] = [];
$_SESSION['color'] = "";

$user = new CRUD;
$result = $user->getUser($loginID);

if (isset($_POST['detail'])) { // show transaction detail
  $tranID = $_POST['tranID'];
  $userID = $_POST['loginID'];
  
  $resultForTrans = $user->getTranDetails($tranID);
  $resultForCustomer = $user->getUser($userID);
  $resultForTran = $user->getTran($tranID);
}

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
    <!-- show transaction detail -->
    <div class="container">
      <h2 class="text-muted h5">Items in process</h2>

      <table class="table table-hover">
        <thead style="background:#cda45e;">
          <tr>
            <th>Item ID</th>
            <th>Item Name</th>
            <th>Quantity</th>
            <th>Grind</th>
            <th>Roast Level</th>
          </tr>
        </thead>

        <tbody>
          <?php foreach ($resultForTrans as $row): ?>
            <tr>
              <td><?= $row['item_id']; ?></td>
              <td><?= $row['item_name']; ?></td>
              <td><?= $row['calc_quan'] . "00g"; ?></td>
              <td><?= $row['grind']; ?></td>
              <td><?= $row['roast_level']; ?></td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>

  <!-- show customer information -->
    <div class="container">
      <h2 class="text-muted h5">Customer Information</h2>

      <table class="table table-hover">
        <thead style="background:#cda45e;">
          <tr>
            <th>User ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Username</th>
            <th>Birthday</th>
            <th>Address</th>
            <th>Email</th>
          </tr>
        </thead>

        <tbody>
          <tr>
            <td><?= $resultForCustomer['user_id']; ?></td>
            <td><?= $resultForCustomer['first_name']; ?></td>
            <td><?= $resultForCustomer['last_name']; ?></td>
            <td><?= $resultForCustomer['username']; ?></td>
            <td><?= $resultForCustomer['bday']; ?></td>
            <td><?= $resultForCustomer['address']; ?></td>
            <td><?= $resultForCustomer['email']; ?></td>
          </tr>
        </tbody>
      </table>

      <?php if ($resultForTran['tran_status'] == 'I'): ?>
        <form action="userAction.php" method="post">
          <input type="hidden" name="tranID" value="<?= $tranID ?>">
          <input type="hidden" name="loginID" value="<?= $loginID ?>">
          <input type="hidden" name="shippedDate" value="<?= date("Y-m-d H:i:s") ?>">
          <input type="submit" name="shipped" value="This order shipped." class="btn form-control text-white mt-5 mb-3 btn-block ml-auto" style="background:#bc8f8f; width: 200px;">
        </form>
      <?php endif ?>

      <div class="text-right h5">
        <a href="showTrans.php"><u>Back to Transactions</u></a>
      </div>
    </div>

  </main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>