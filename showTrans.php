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
$month = date('Y-m');
$resultForTrans = $user->getTrans('I', $month);
$thisMonth[] = $month;
$tranMonths = array_diff($user->getTranMonths('', 'D', ''), $thisMonth);

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
</style>
</head>
<body>

  <?php include('parts/navbar.php') ?>
  
  <main class="my-5" style="margin-top:75px !important;">

    <?php if (!empty($message)): ?>
      <?= "<p class='pt-4 $color text-center' style='font-size: 20px;'>$message</p>" ?>
    <?php endif ?>

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

        <?php if (empty($resultForTrans[0])): ?>
          <tr>
            <td colspan="5">
              <p class='text-center text-dark h4 my-3'>No data.</p>
            </td>
          </tr>
        <?php else: ?>
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
                  <button type="submit" name="detail" class="btn form-control text-white" style="background:#a0522d;">Details</button>
                </form>
              </td>
            </tr>
          <?php endforeach ?>
        <?php endif ?>
      </table>
    </div>

    <!-- show completed transactions on this month-->
    <div class="container mt-5 ">
      <h2 class="text-muted h3 align-self-end">Completed Transactions on <?= $month ?></h2>
      
      <table class="table table-striped table-hover">
        <thead class="text-cark" style="background:#a0522d;">
          <tr>
            <th>Transaction ID</th>
            <th>Login ID</th>
            <th>Total Payment</th>
            <th>Transaction Date</th>
            <th>Staff Name</th>
            <th>Shipped Date</th>
            <th></th>
          </tr>
        </thead>
      
        <?php
          $resultForCompTransThisMonth = $user->getTrans('S', $month);

          if (empty($resultForCompTransThisMonth[0])) {
            echo "<tr>
              <td colspan='7'>
                <p class='text-center text-dark h4 my-3'>No data.</p>
              </td>
            </tr>";
          } else {
            foreach ($resultForCompTransThisMonth as $row) {
            $resultForStaffUsername = $user->getUser($row['staff_id']);
              echo "<tr>";
                echo "<td class='align-middle'>" . $row['tran_id'] . "</td>";
                echo "<td class='align-middle'>" . $row['login_id'] . "</td>";
                echo "<td class='align-middle'>USD " .  $row['total_pay'] . "</td>";
                echo "<td class='align-middle'>" . $row['tran_date'] . "</td>";
                echo "<td class='align-middle'>" . $resultForStaffUsername['username'] . "</td>";
                echo "<td class='align-middle'>" . $row['shipped_date'] . "</td>";
                echo "<td>";
                  echo "<form action='showTranDetail.php' method='post'>";
                    echo "<input type='hidden' name='tranID' value='" . $row['tran_id'] . "'>";
                    echo "<input type='hidden' name='loginID' value='" . $row['login_id'] . "'>";
                    echo "<button type='submit' name='detail' class='btn form-control text-white' style='background:#a0522d;'>Details</button>";
                  echo "</form>";
                echo "</td>";
              echo "</tr>";
            }
          }
        ?>  
      </table>
    </div>
    
    <!-- show selected month's transactions -->
    <div class="container mt-5 ">
      <div id="month" class="input-group mb-3">
        <p class="text-muted h4 pr-3 mb-0 align-self-center">Past transactions &rarr; </p>
        <form action="#month" method="post" class="form-inline">
          <select name = "month" class="custom-select form-inline mr-2" id="inputGroupSelect01" style="width:100px;">
            <?php foreach ($tranMonths as $row): ?>
              <option value="<?= $row ?>"><?= $row ?></option>
            <?php endforeach ?>
          </select>
          <button type="submit" name="monthForTran" class="btn form-control text-white ml-auto" style="background:#a0522d; width:100px;">Search</button>
        </form>
      </div>

      <?php 
        if (isset($_POST['monthForTran'])) {
          $month = $_POST['month'];

          $resultForCompTrans = $user->getTrans('S', $month);

          if (empty($resultForCompTrans[0])) {
            echo "<h2 class='text-muted h3'>Completed Transactions on " . $month . "</h2>";
    
            echo "<table class='table table-striped table-hover'>
                    <thead class='text-cark' style='background:#a0522d;'>
                      <tr>
                        <th>Transaction ID</th>
                        <th>Login ID</th>
                        <th>Total Payment</th>
                        <th>Transaction Date</th>
                        <th>Staff Name</th>
                        <th>Shipped Date</th>
                        <th></th>
                      </tr>
                    </thead>";
            echo "<tr>
                    <td colspan='7'>
                      <p class='text-center text-dark h4 my-3'>No data.</p>
                    </td>
                  </tr>
                </table>";
          } else {
            echo "<h2 class='text-muted h3'>Completed Transactions on " . $month . "</h2>";
    
            echo "<table class='table table-striped table-hover'>
                    <thead class='text-cark' style='background:#a0522d;'>
                      <tr>
                        <th>Transaction ID</th>
                        <th>Login ID</th>
                        <th>Total Payment</th>
                        <th>Transaction Date</th>
                        <th>Staff Name</th>
                        <th>Shipped Date</th>
                        <th></th>
                      </tr>
                    </thead>";

            foreach ($resultForCompTrans as $row) {
              $resultForStaffUsername = $user->getUser($row['staff_id']);

              echo "<tr>";
                echo "<td class='align-middle'>" . $row['tran_id'] . "</td>";
                echo "<td class='align-middle'>" . $row['login_id'] . "</td>";
                echo "<td class='align-middle'>USD " .  $row['total_pay'] . "</td>";
                echo "<td class='align-middle'>" . $row['tran_date'] . "</td>";
                echo "<td class='align-middle'>" . $resultForStaffUsername['username'] . "</td>";
                echo "<td class='align-middle'>" . $row['shipped_date'] . "</td>";
                echo "<td>";
                  echo "<form action='showTranDetail.php' method='post'>";
                    echo "<input type='hidden' name='tranID' value='" . $row['tran_id'] . "'>";
                    echo "<input type='hidden' name='loginID' value='" . $row['login_id'] . "'>";
                    echo "<button type='submit' name='detail' class='btn form-control text-white' style='background:#a0522d;'>Details</button>";
                  echo "</form>";
                echo "</td>";
              echo "</tr>";
            }
            echo "</table>";
          }
        }
      ?>  
        
    </div>
        
  </main>
      
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>