<?php

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

$month = date('Y-m');

if (isset($_POST['detail'])) { // show user detail
  $userID = $_POST['userID'];
  
  $thisMonth[] = $month;
  $tranMonths = array_diff($user->getTranMonths($userID, 'A', 12), $thisMonth);
  $tranMonthsForSearch = array_diff($user->getTranMonths($userID, 'D', ''), $thisMonth);

  $resultForCustomer = $user->getUser($userID);
  $transInProcess = $user->getTransByUser($userID, 'I', '');
  $transInThisMonth = $user->getTransByUser($userID, 'S', $month);
}

// this month pay
$totalPayThisMonth = $user->getTotalPayByUserID($userID, $month);

// past months pay
$totalPays = [];
foreach ($tranMonths as $pastMonth) {
  $totalPays[$pastMonth] = $user->getTotalPayByUserID($userID, $pastMonth);
}


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
<title>Transaction Detail</title>
<style>
  body {
    background-color: white;
  }
</style>
</head>
<body>

  <?php include('parts/navbar.php') ?>

  <main class="my-5" style="margin-top:75px !important;">


    <!-- show customer detail -->
    <div class="container">
      <h2 class="text-muted h3">User Infomation</h2>

      <table class="table table-striped table-hover">
        <thead style="background:#d2691e;">
          <tr>
            <th>User ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Username</th>
            <th>Birthday</th>
            <th>Postal Code</th>
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
            <td><?= substr($resultForCustomer['postal'], 0, 3) . "-" . substr($resultForCustomer['postal'], 3); ?></td>
            <td><?= $resultForCustomer['address']; ?></td>
            <td><?= $resultForCustomer['email']; ?></td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- show transactions in process -->
    <div class="container">
      <h2 class="text-muted h3">Transactions in process</h2>
      <table class="table table-striped table-hover">
        <thead class="text-dark" style="background:#a0522d;">
          <tr>
            <th>Transaction ID</th>
            <th>Login ID</th>
            <th>Total Payment</th>
            <th>Transaction Date</th>
            <th></th>
          </tr>
        </thead>

        <?php if (empty($transInProcess[0])): ?>
          <tr>
            <td colspan="5">
              <p class='text-center text-dark h4 my-2'>No data.</p>
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($transInProcess as $row): ?>
            <tr>
              <td class="align-middle"><?= $row['tran_id'] ?></td>
              <td class="align-middle"><?= $row['login_id'] ?></td>
              <td class="align-middle">USD <?= $row['total_pay'] ?></td>
              <td class="align-middle"><?= $row['tran_date'] ?></td>
              <td>
                <form action="showTranDetail.php" method="post">
                  <input type="hidden" name="tranID" value="<?= $row['tran_id'] ?>">
                  <input type="hidden" name="loginID" value="<?= $row['login_id'] ?>">
                  <button type="submit" name="detail" class="btn form-control text-white" style="background:#a0522d;">Details</button>
                </form>
              </td>
            </tr>
          <?php endforeach ?>
        <?php endif ?>
      </table>
    </div>

    <!-- show transactions in this month -->
    <div class="container">
      <h2 class="text-muted h3">Completed Transactions in this month</h2>

      <table class="table table-striped table-hover">
        <thead class="text-dark" style="background:#a0522d;">
          <tr>
            <th>Transaction ID</th>
            <th>Login ID</th>
            <th>Total Payment</th>
            <th>Transaction Date</th>
            <th></th>
          </tr>
        </thead>

        <?php if (empty($transInThisMonth[0])): ?>
          <tr>
            <td colspan="5">
              <p class='text-center text-dark h4 my-2'>No data.</p>
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($transInThisMonth as $row): ?>
            <tr>
              <td class="align-middle"><?= $row['tran_id'] ?></td>
              <td class="align-middle"><?= $row['login_id'] ?></td>
              <td class="align-middle">USD <?= $row['total_pay'] ?></td>
              <td class="align-middle"><?= $row['tran_date'] ?></td>
              <td>
                <form action="showTranDetail.php" method="post">
                  <input type="hidden" name="tranID" value="<?= $row['tran_id'] ?>">
                  <input type="hidden" name="loginID" value="<?= $row['login_id'] ?>">
                  <button type="submit" name="detail" class="btn form-control text-white" style="background:#a0522d;">Details</button>
                </form>
              </td>
            </tr>
          <?php endforeach ?>
        <?php endif ?>
      </table>

      <div class="text-right h5">
        <a href="showUsers.php"><u>Back to Users</u></a>
      </div>
    </div>

    <!-- show total pay in each month -->
    <div class="container">
      <h2 class="text-muted h3 mr-auto">Total Pay in Each Month</h2>

      <table class="table table-striped table-hover w-50 mr-auto">
        <thead style="background:#daa520;">
          <tr>
            <th>Month</th>
            <th>Total</th>
          </tr>
        </thead>

        <tbody>
          <?php $totalPayment = 0 ?>
          <!-- past months -->
          <?php foreach ($totalPays as $pastMonth => $pay): ?>
            <tr>
              <td><?= $pastMonth ?></td>
              <td>
                <?php
                  echo round($pay['Sum'], 2);
                  $totalPayment += round($pay['Sum'], 2);
                ?>
              </td>
            </tr>
          <?php endforeach ?>
          <!-- this month -->
          <?php if ($totalPayThisMonth['Sum'] != 0): ?>
              <tr>
                <td><?= $month ?></td>
                <td>
                  <?php 
                    echo round($totalPayThisMonth['Sum'], 2);
                    $totalPayment += round($totalPayThisMonth['Sum'], 2);
                  ?>
                </td>
              </tr>
            <?php endif ?>
          <!-- total payment -->
          <tr class="text-success">
              <td>Total</td>
              <td><?= $totalPayment ?></td>
            </tr>
        </tbody>
      </table>
    </div>

    <!-- show selected month's transactions -->
    <div class="container mt-5 ">
      <div id="month" class="input-group mb-3">
        <p class="text-muted h4 pr-3 mb-0 align-self-center">Past transactions &rarr; </p>
        <form action="showUserPastTran.php" method="post" class="form-inline">
          <select name="month" class="custom-select form-inline mr-2" id="inputGroupSelect01" style="width:100px;">
            <?php foreach ($tranMonthsForSearch as $row): ?>
              <option value="<?= $row ?>"><?= $row ?></option>
            <?php endforeach ?>
          </select>
          <input type="hidden" name="userID" value="<?= $userID ?>">
          <button type="submit" name="monthForTran" class="btn form-control text-white ml-auto" style="background:#a0522d; width:100px;">Search</button>
        </form>
      </div>
        
    </div>

  </main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>