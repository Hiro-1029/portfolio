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

if ($result['status'] == 'U' || $result['status'] == 'R' ||empty($loginID)) {
  header('Location: logout.php');
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
<title>Add Item</title>
<style>
  body {
    background-color: white;
  }
</style>
</head>
<body>

  <?php include('parts/navbar.php') ?>

  <section class="container text-center text-dark my-3">

    <div class="text-center h4">
      <?php if (!empty($message)): ?>
        <?= "<p class='pt-4 $color text-center' style='font-size: 20px;'>$message<br> </p>" ?>
      <?php endif ?>
    </div>

    <div class="section-title">
      <p>Add Item</p>
    </div>

    <div class="w-50 mx-auto my-2 mt-lg-0 text-dark">

      <form action="userAction.php" method="post" enctype="multipart/form-data" class="text-center mx-auto">
        <table width="100%">
          <tr>
            <td>Name</td>
            <td>
              <input type="text" name="itemName" class="form-control w-100" required>
            </td>
          </tr>
          <tr>
            <td>Price</td>
            <td>
              <input type="number" step="0.01" name="itemPrice" class="form-control w-100" required>
            </td>
          </tr>
          <tr>
            <td>Quantity</td>
            <td>
              <input type="number" name="itemQuantity" class="form-control w-100" required>
            </td>
          </tr>
          <tr>
            <td>Roast Level</td>
            <td>
              <select name="roast" class="form-control w-100 mx-auto" required>
                <option value="">Choose</option>
                <option value="light">Light</option>
                <option value="medium">Medium</option>
                <option value="dark">Dark</option>
                <option value="other">Other</option>
              </select>
            </td>
          </tr>
          <tr>
            <td>Description</td>
            <td>
              <textarea name="itemDesc" cols="30" rows="10" class="form-control w-100" required></textarea>
            </td>
          </tr>
          <tr>
          <tr>
            <td>Picture</td>
            <td>
              <div class="custom-file">
                <label for="itemPicture" class="custom-file-label">Choose File</label>
                <input type="file" id="itemPicture" name="itemPicture" class="custom-file-input" required>
              </div>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <input type="submit" name="addItem" value="Add Item" class="btn rounded-pill text-white w-50 mt-4" style="background:#cda45e;">
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
