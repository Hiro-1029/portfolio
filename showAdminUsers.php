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

if ($result['status'] == 'U' || $result['status'] == 'R' ||empty($loginID)) {
  header('Location: logout.php');
  exit;
}

$rowsForValid = $user->getSelectedAdminUsers('A');
$rowsForDeleted = $user->getSelectedAdminUsers('R');

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
<title>Admin Users</title>
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

    <!-- valid Admin users -->
    <div class="container">
      <h2 class="text-muted h3">Valid Admin Users List</h2>

      <table class="table table-hover">
        <thead style="background:#bc8f8f;">
          <tr>
            <th>User ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Username</th>
            <th>Start Date</th>
            <th>Postal Code</th>
            <th>Address</th>
            <th>Email</th>
            <th></th>
          </tr>
        </thead>

        <tbody>
          <?php foreach ($rowsForValid as $row): ?>
            <tr>
              <td><?= $row['user_id']; ?></td>
              <td><?= $row['first_name']; ?></td>
              <td><?= $row['last_name']; ?></td>
              <td><?= $row['username']; ?></td>
              <td><?= $row['bday']; ?></td>
              <td><?= substr($row['postal'], 0, 3) . "-" . substr($row['postal'], 3); ?></td>
              <td><?= $row['address']; ?></td>
              <td><?= $row['email']; ?></td>
              <td>
                <form action="userAction.php" method="post">
                  <input type="hidden" name="userID" value="<?= $row['user_id'] ?>">
                  <input type="submit" name="deleteAdmin" value="Delete" class="btn form-control text-white" style="background:#bc8f8f;">
                </form>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>

    <!-- Deleted Admin users -->
    <div class="container mt-5">
      <h2 class="text-muted h3">Deleted Admin Users List</h2>

      <table class="table table-hover">
        <thead style="background:#bc8f8f;">
          <tr>
            <th>User ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Username</th>
            <th>Start Date</th>
            <th>Address</th>
            <th>Email</th>
            <th></th>
          </tr>
        </thead>

        <tbody>
          <?php foreach ($rowsForDeleted as $row): ?>
            <tr>
              <td><?= $row['user_id']; ?></td>
              <td><?= $row['first_name']; ?></td>
              <td><?= $row['last_name']; ?></td>
              <td><?= $row['username']; ?></td>
              <td><?= $row['bday']; ?></td>
              <td><?= $row['address']; ?></td>
              <td><?= $row['email']; ?></td>
              <td>
                <form action="userAction.php" method="post">
                  <input type="hidden" name="userID" value="<?= $row['user_id'] ?>">
                  <input type="submit" name="restoreAdmin" value="Restore" class="btn form-control text-white" style="background:#bc8f8f;">
                </form>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>

  </main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>