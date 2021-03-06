<?php

require_once('classes/crud.php');

$now = time();
if ($now > $_SESSION['expire']) {
  unset($_SESSION['message']);
  unset($_SESSION['color']);
} else {
  $message = $_SESSION['message'];
  $color = $_SESSION['color'];
}

$loginID = $_SESSION['login_id'];

$user = new CRUD;
$result = $user->getUser($loginID);

if ($result['status'] == 'U' || $result['status'] == 'R' ||empty($loginID)) {
  header("location: logout.php");
  exit;
}

$rows = $user->getAllUsers();

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
    <div class="container">
      <h2 class="text-muted h3">User List</h2>

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
            <th></th>
          </tr>
        </thead>

        <tbody>
          <?php foreach ($rows as $row): ?>
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
              
                <form action="showUserDetail.php" method="post">
                  <input type="hidden" name="userID" value="<?= $row['user_id'] ?>">
                  <button type="submit" name="detail" class="btn form-control text-white" style="background:#d2691e;">Details</button>
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