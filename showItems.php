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

  <!-- show items of selected type -->
  <div class="container mt-5" style="margin-top:75px !important;">

    <div id="type" class="input-group mb-3">
      <p class="text-muted h5 pr-3 mb-0 align-self-center">Select item type &rarr; </p>
      <form action="#type" method="post" class="form-inline">
        <select name="itemStatus" id="inputGroupSelect01" class="form-control form-inline mr-2" style="width:120px;">
            <option value="">Choose</option>
            <option value="A">All</option>
            <option value="N">New arrival</option>
            <option value="E">Existing items</option>
            <option value="S">Sold out</option>
          </select>
          <button type="submit" name="itemType" class="btn form-control ml-auto text-white" style="background-color:#cda45e; width:100px;">Search</button>
      </form>
    </div>
  </div>

  <?php if (isset($_POST['itemType'])) {
    $status = $_POST['itemStatus'];
    $rows = $user->getItems($status);

    if (empty($rows[0])) {
      echo "<p class='text-center text-dark h4 my-3'>No data.</p>";
    } else {
      echo "<h2 class='text-dark text-center mt-5'>Item List</h2>";

      echo "<section class='my-5 text-dark pt-0'>";

        echo "<div class='container row mx-auto'>";
          foreach ($rows as $row) {
            echo "<div class='col-lg-6 my-3'>";
              echo "<form action='userAction.php' method='post'>";
                echo "<table class='table'>";
                  echo "<tr style='background:#cda45e;'>";
                    echo "<td>ID</td>";
                    echo "<td>" . $row['item_id'] . "</td>";
                  echo "</tr>";
                  echo "<tr>";
                    echo "<td>Name</td>";
                    echo "<td>" . $row['item_name'] . "</td>";
                  echo "</tr>";
                  echo "<tr>";
                    echo "<td>Price</td>";
                    echo "<td>" . $row['item_price'] . "</td>";
                  echo "</tr>";
                  echo "<tr>";
                    echo "<td>Quantity</td>";
                    echo "<td>" . $row['item_quantity'] . "</td>";
                  echo "</tr>";
                  echo "<tr>";
                    echo "<td>Roast Level</td>";
                    echo "<td>" . $row['roast_level'] . "</td>";
                  echo "</tr>";
                  echo "<tr>";
                    echo "<td>Description</td>";
                    echo "<td>" . $row['item_desc'] . "</td>";
                  echo "</tr>";
                  echo "<tr>";
                    echo "<td colspan='2' class='text-center'><img src='assets/img/menu/" . $row['item_picture'] . "' alt='Item Photo' width='200px'></td>";
                  echo "</tr>";
                  echo "<tr >";
                    echo "<td colspan='2' class='text-center p-0' style='border-style:none;'>";
                      echo "<input type='hidden' name='itemID' value='" . $row['item_id'] . "'>";
                    echo "</td>";
                  echo "</tr>";
                  echo "<tr>";
                    echo "<td colspan='2' class='text-center'>";
                    echo "<input type='submit' name='getItem' value='Change' class='btn rounded-pill text-white w-50 mt-2' style='background:#cda45e;'>";
                    echo "</td>";
                  echo "</tr>";
                echo "</table>";
              echo "</form>";
            echo "</div>";
          }
        echo "</div>";

      echo "</section>";
    }
  }
  ?>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>