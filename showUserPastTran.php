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

if (isset($_POST['monthForTran'])) { // show user detail
  $userID = $_POST['userID'];
  $month = $_POST['month'];
  
  $resultForCustomer = $user->getUser($userID);
  $resultForCompTrans = $user->getTransByUser($userID, 'S', $month);
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
    </div>

    <!-- show selected month's transactions -->
    <div class="container mt-5 ">

      <h2 class="text-muted h3">Completed Transactions on <?= $month ?></h2>

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
        ?>
      </table> 

      <div class="text-right h5">
        <!-- <a href="showUserDetail.php"><u>Back to User Detail</u></a> -->
        <form action="showUserDetail.php" method="post">
          <input type="hidden" name="userID" value="<?= $userID ?>">
          <button type="submit" name="detail" class="btn m-0 p-0" style="border-bottom: solid #cda45e 2px; color:#cda45e; font-size:20px; line-height:20px;">Back to User Detail</button>
        </form>
      </div>
    </div>

  </main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>