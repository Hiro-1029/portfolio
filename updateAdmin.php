<?php

require_once('classes/crud.php');

$loginID = $_SESSION['login_id'];
$messages[] = $_SESSION['message'];
$color = $_SESSION['color'];

$user = new CRUD;
$result = $user->getUser($loginID);

if (empty($loginID)) {
  header('Location: login.php');
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
      <p>Your Profile</p>
    </div>

    <div class="w-50 mx-auto my-2 mt-lg-0 text-dark">

      <form action="userAction.php" method="post" class="text-center mx-auto">
        <table width="100%">
          <tr>
            <td>Username</td>
            <td>
              <input type="text" name="username" value="<?= $result['username'] ?>" class="form-control w-100">
            </td>
          </tr>
          <tr>
            <td>First Name</td>
            <td>
              <input type="text" name="firstName" value="<?= $result['first_name'] ?>" class="form-control w-100">
            </td>
          </tr>
          <tr>
            <td>Last Name</td>
            <td>
              <input type="text" name="lastName" value="<?= $result['last_name'] ?>" class="form-control w-100">
            </td>
          </tr>
          <tr>
            <td>Birthday</td>
            <td>
              <input type="date" name="bday" value="<?= $result['bday'] ?>" class="form-control w-100">
            </td>
          </tr>
          <tr>
            <td>Address</td>
            <td>
              <input type="text" name="address" value="<?= $result['address'] ?>" class="form-control w-100">
            </td>
          </tr>
          <tr>
          <tr>
            <td>Email</td>
            <td>
              <input type="email" name="email" value="<?= $result['email'] ?>" class="form-control w-100">
            </td>
          </tr>
          <tr>
            <td>
              <input type="hidden" name="loginID" value="<?= $result['login_id'] ?>">
            </td>
            <td>
              <input type="hidden" name="status" value="<?= $result['status'] ?>">
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <?php if (empty($messages[0])): ?>
                <p class="pt-3 text-dark">
                  If you'd like to change your profile information, <br>please change your datas above and press the button below.
                </p>
              <?php else: ?>
                <?= "<p class='pt-3 $color'>" ?>
                  <?php foreach ($messages as $message): ?>
                    <?= $message . "<br>" ?>
                  <?php endforeach ?>
                </p>
              <?php endif ?>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <input type="submit" name="updateUser" value="Update Profile" class="btn rounded-pill text-white w-50 mt-2" style="background:#cda45e;">
            </td>
          </tr>
        </table>
      </form>

    </div>
  </section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
