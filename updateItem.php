<?php

require_once('classes/crud.php');

$loginID = $_SESSION['login_id'];
$messages[] = $_SESSION['message'];
$color = $_SESSION['color'];
$itemID = $_SESSION['item_id'];

$user = new CRUD;
$result = $user->getUser($loginID);
$resultForItem = $user->getItem($itemID);

if ($result['status'] == 'U' || empty($loginID)) {
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
<title>Update Item Info</title>
<style>
  body {
    background-color: white;
  }
</style>
</head>
<body>

  <?php include('parts/navbar.php') ?>

  <section class="container text-center text-dark my-3">

    <div class="section-title pb-0">
      <p>Item Info</p>
    </div>

    <div class="pb-3">
      <?php if (empty($messages[0])): ?>
        <p class="h4 pt-3 text-dark">
          If you'd like to update item information, <br>please change item datas and press the button below.
        </p>
      <?php else: ?>
        <?= "<p class='h4 pt-3 $color'>" ?>
          <?php foreach ($messages as $message): ?>
            <?= $message . "<br>" ?>
          <?php endforeach ?>
        </p>
      <?php endif ?>
    </div>

    <img src="assets/img/menu/<?= $resultForItem['item_picture'] ?>" alt='Item Photo' width='400px'>

    <div class="w-50 mx-auto mt-lg-0 text-dark pt-4">

      <form action="userAction.php" method="post" enctype="multipart/form-data" class="text-center mx-auto my-2">
        <table width="100%">
          <tr>
            <td>Name</td>
            <td>
              <input type="text" name="itemName" value="<?= $resultForItem['item_name'] ?>" class="form-control w-100">
            </td>
          </tr>
          <tr>
            <td>Price</td>
            <td>
              <input type="number" step="0.01" name="itemPrice" value="<?= $resultForItem['item_price'] ?>" class="form-control w-100">
            </td>
          </tr>
          <tr>
            <td>Quantity</td>
            <td>
              <input type="number" name="itemQuantity" value="<?= $resultForItem['item_quantity'] ?>" class="form-control w-100">
            </td>
          </tr>
          <tr>
            <td>Roast Level</td>
            <td>
              <select name="roast" class="form-control w-100 mx-auto">
                <?php
                  if ($resultForItem['roast_level'] == 'light') {
                    echo "<option value='light' selected>Light</option>";
                    echo "<option value='medium'>Medium</option>";
                    echo "<option value='dark'>Dark</option>";
                    echo "<option value='other'>Other</option>";
                  } elseif ($resultForItem['roast_level'] == 'medium') {
                    echo "<option value='light'>Light</option>";
                    echo "<option value='medium' selected>Medium</option>";
                    echo "<option value='dark'>Dark</option>";
                    echo "<option value='other'>Other</option>";
                  } elseif ($resultForItem['roast_level'] == 'dark') {
                    echo "<option value='light'>Light</option>";
                    echo "<option value='medium'>Medium</option>";
                    echo "<option value='dark' selected>Dark</option>";
                    echo "<option value='other'>Other</option>";
                  } else {
                    echo "<option value='light'>Light</option>";
                    echo "<option value='medium'>Medium</option>";
                    echo "<option value='dark'>Dark</option>";
                    echo "<option value='other' selected>Other</option>";
                  }
                ?>
              </select>
            </td>
          </tr>
          <tr>
            <td>Status</td>
            <td>
              <select name="itemStatus" class="form-control w-100 mx-auto">
                <?php 
                  if ($resultForItem['item_status'] == 'A') {
                    echo "<option value='A' selected>All</option>";
                    echo "<option value='N'>New arrival</option>";
                    echo "<option value='E'>Existing items</option>";
                    echo "<option value='S'>Sold out</option>";
                  } elseif ($resultForItem['item_status'] == 'N') {
                    echo "<option value='A'>All</option>";
                    echo "<option value='N' selected>New arrival</option>";
                    echo "<option value='E'>Existing items</option>";
                    echo "<option value='S'>Sold out</option>";
                  } elseif ($resultForItem['item_status'] == 'E') {
                    echo "<option value='A'>All</option>";
                    echo "<option value='N'>New arrival</option>";
                    echo "<option value='E' selected>Existing items</option>";
                    echo "<option value='S'>Sold out</option>";
                  } else {
                    echo "<option value='A'>All</option>";
                    echo "<option value='N'>New arrival</option>";
                    echo "<option value='E'>Existing items</option>";
                    echo "<option value='S' selected>Sold out</option>";
                  }
                ?>
              </select>
            </td>
          </tr>
          <tr>
            <td>Description</td>
            <td>
              <textarea name="itemDesc" cols="30" rows="10" class="form-control w-100"><?= $resultForItem['item_desc'] ?></textarea>
            </td>
          </tr>
          <tr>
            <td>Picture</td>
            <td>
              <input type="file" name="itemPicture" class="form-control w-100">
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <input type="hidden" name="itemID" value="<?= $resultForItem['item_id'] ?>" class="form-control w-100">
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <input type="submit" name="updateItem" value="Update Info" class="btn rounded-pill text-white w-50 mt-2" style="background:#cda45e;">
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
