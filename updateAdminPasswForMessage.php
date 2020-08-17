<?php

require_once('classes/crud.php');

$loginID = $_SESSION['login_id'];
$message = $_SESSION['message'];
$color = $_SESSION['color'];
$userID = $_SESSION['userID'];

$user = new CRUD;
$result = $user->getUser($loginID);
$resultByUserID = $user->getUserByUserID($userID);


if ($result['status'] != 'S') {
  header('Location: logout.php');
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
<script src="https://kit.fontawesome.com/cf7a71e984.js" crossorigin="anonymous"></script>
<title>Admin Profile</title>
<style>
  body {
    background-color: white;
  }
</style>
</head>
<body>

  <?php include('parts/navbar.php') ?>

  <section class="container text-center text-dark my-3">

    <div class="section-title">
      <p>Change Password</p>
    </div>

    <div class="w-50 mx-auto my-2 mt-lg-0 text-dark">

      <?php if (!empty($message)): ?>
        <?= "<p class='pt-4 $color text-center' style='font-size: 20px;'>$message<br> </p>" ?>
      <?php endif ?>

      <form action="userAction.php" method="post" class="mb-5">
        <div class="col-md-6 form-group mx-auto">
          <label for="currentPassw">Current Password</label>
          <input type="password" id="currentPassw" name="currentPassw" class="form-control mb-2" required>
          <div class="validate"></div>
        </div>

        <div class="col-md-6 form-group mx-auto">
          <label for="newPassw">New Password</label>
          <input type="password" id="newPassw" name="newPassw" class="form-control mb-2" required>
          <div class="validate"></div>
        </div>

        <div class="col-md-6 form-group mx-auto">
          <label for="confPassw">Confirmation Password</label>
          <input type="password" id="confPassw" name="confPassw" class="form-control mb-2" required>
          <div class="validate"></div>
        </div>
        
        <input type="hidden" name="userID" value="<?= $userID ?>">

        <?php if (empty($message)): ?>
          <p class="h5 text-center text-danger mb-3">If you really want to change your password, <br> change the button below.</p>
        <?php endif ?>

        <div id="login" class="text-center nav-menu mt-4">
          <input type="submit" name="updateAdminPassw" value="Change" class="btn rounded-pill text-white w-50 mt-2" style="background:#d2691e;">
        </div>

      </form>

    </div>

  </section>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
