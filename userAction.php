<?php

require_once('classes/crud.php');

$myObj = new CRUD;

if (isset($_POST['register'])) { // register
  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $bday = $_POST['bday'];
  $address = $_POST['address'];
  $email = $_POST['email'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $confPass = $_POST['confPass'];
  $status = $_POST['status'];

  if ($password == $confPass) {
    $myObj->register($firstName, $lastName, $bday, $address, $email, $username, $password, $status);
  } else {
    $_SESSION['message'] = "Your password and confirmation password don't match.";
    if ($status == 'A') {
      header('Location: registerAdmin.php');
    } else {
      header('Location: registerForMessage.php');
    }
  }

} elseif (isset($_POST['login'])) { // login
  $username = $_POST['username'];
  $password = $_POST['password'];

  $myObj->login($username, $password);

} elseif (isset($_POST['updateUser'])) { // update user profile
  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $address = $_POST['address'];
  $email = $_POST['email'];
  $loginID = $_POST['loginID'];
  $status = $_POST['status'];

  $myObj->updateUser($firstName, $lastName, $address, $email, $loginID, $status);
 
} elseif (isset($_POST['addItem'])) { // add item information
  $itemName = $_POST['itemName'];
  $itemPrice = $_POST['itemPrice'];
  $itemQuantity = $_POST['itemQuantity'];
  $roast = $_POST['roast'];
  $itemDesc = $_POST['itemDesc'];
  $itemPicture = $_FILES['itemPicture']['name'];

  $target_dir = "assets/img/menu/";
  $target_file = $target_dir . basename($itemPicture);

  $ans = $myObj->addItem($itemName, $itemPrice, $itemQuantity, $roast, $itemDesc, $itemPicture);

  if ($ans == 1) {
    move_uploaded_file($_FILES['itemPicture']['tmp_name'], $target_file);
    $_SESSION['message'] = "Item added successfully.";
    $_SESSION['color'] = 'text-success';
    header("Location: addItem.php");
  } else {
    $_SESSION['message'] = "Error in adding an item.";
    $_SESSION['color'] = 'text-danger';
    header("Location: addItem.php");
  }

} elseif (isset($_POST['getItem'])) { // get selected item information
  $itemID = $_POST['itemID'];
  $_SESSION['item_id'] = $itemID;
  header('Location: updateItem.php');

} elseif (isset($_POST['updateItem'])) { // update item information
  $itemID = $_POST['itemID'];
  $itemName = $_POST['itemName'];
  $itemPrice = $_POST['itemPrice'];
  $itemQuantity = $_POST['itemQuantity'];
  $itemDesc = $_POST['itemDesc'];
  $roast = $_POST['roast'];
  $itemPicture = $_FILES['itemPicture']['name'];
  $itemStatus = $_POST['itemStatus'];

  $target_dir = "assets/img/menu/";
  $target_file = $target_dir . basename($itemPicture);

  $ans = $myObj->updateItem($itemID, $itemName, $itemPrice, $itemQuantity, $roast, $itemDesc, $itemPicture, $itemStatus);

  if ($ans == 1) {
    move_uploaded_file($_FILES['itemPicture']['tmp_name'], $target_file);
    $_SESSION['message'] = "Item added successfully.";
    $_SESSION['color'] = 'text-success';
    header('Location: updateItem.php');
  } else {
    $_SESSION['message'] = "Error in updating an item.<br>";
    $_SESSION['color'] = 'text-danger';
    header('Location: updateItem.php');
  }

} elseif (isset($_POST['updatePassw'])) { // update password for user
  $loginID = $_POST['loginID'];
  $currentPassw = $_POST['currentPassw'];
  $newPassw = $_POST['newPassw'];
  $confPassw = $_POST['confPassw'];

  $result = $myObj->getCurrentPassw($loginID);

  if (password_verify($currentPassw, $result['password'])) {
    if ($newPassw == $confPassw) {
      $myObj->updatePassw($loginID, $newPassw);
    } else {
      $_SESSION['message'] = "New Password and Confirmation Password do not match.";
      $_SESSION['color'] = 'text-danger';
      header('Location: updatePasswForMessage.php');
    }
  } else {
    $_SESSION['message'] = "Your current password was incorrect.";
    $_SESSION['color'] = 'text-danger';
    header('Location: updatePasswForMessage.php');
  }

} elseif (isset($_POST['updateAdminPassw'])) { // update Admin password by Super Admin
  $userID = $_POST['userID'];
  $currentPassw = $_POST['currentPassw'];
  $newPassw = $_POST['newPassw'];
  $confPassw = $_POST['confPassw'];
  $loginID = $userID;

  $result = $myObj->getCurrentPassw($loginID);

  if (password_verify($currentPassw, $result['password'])) {
    if ($newPassw == $confPassw) {
      $myObj->updatePassw($loginID, $newPassw);
    } else {
      $_SESSION['message'] = "New Password and Confirmation Password do not match.";
      $_SESSION['color'] = 'text-danger';
      header('Location: updateAdminPasswForMessage.php');
    }
  } else {
    $_SESSION['message'] = "The admin current password was incorrect.";
    $_SESSION['color'] = 'text-danger';
    header('Location: updateAdminPasswForMessage.php');
  }

} elseif (isset($_POST['putItem'])) { // put item into cart
  $loginID = $_POST['loginID'];
  $itemID = $_POST['itemID'];

  if (empty($loginID)) {
    $_SESSION['start'] = time();
    $_SESSION['expire'] = $_SESSION['start'] + 0.1;
    $_SESSION['message'] = "If you would like to purchase items online, please login.";
    $_SESSION['color'] = "text-warning";
    header('Location: loginForMessage.php');
  } else {
    $myObj->insertItem($loginID, $itemID);
  }

} elseif(isset($_POST['deleteItem'])) { // delete item from cart
  $calcID = $_POST['calcID'];

  $myObj->deleteItemFromCart($calcID);

} elseif (isset($_POST['updateCalc'])) { // update items' quantity and grind 
  $calcID = $_POST['calcID'];
  $calcQuan = $_POST['calcQuan'];
  $grind = $_POST['grind'];

  $myObj->updateItemFromCart($calcID, $calcQuan, $grind);

} elseif (isset($_POST['order'])) { // order items
  $loginID = $_POST['loginID'];
  $totalPay = $_POST['totalPay'];
  $date = $_POST['tranDate'];
  $calcIDs = $_POST['calcIDs'];

  $ansForCheck = $myObj->checkQuan($calcIDs); 
    // check whether stock is enough or not

  if ($ansForCheck == count($calcIDs)) {
    $ansForOrder = $myObj->order($loginID, $totalPay, $date);
      // insert information into 'transactions' table
    if ($ansForOrder[0] == 1) {
      $tranID = $ansForOrder[1];
      $myObj->updateStatusForCalc($calcIDs, $tranID);  
        // update calc_status from 'I' to 'O' , 'I': In progress, 'O': ordered 
    }

  } else {
    $_SESSION['message'] = 
      "The stock of ". $row['item_name'] ." isn't enough. <br>
      Only ". $row['item_quantity'] ."00g left.<br> 
      Sorry for the inconvenience.";
    $_SESSION['color'] = 'text-danger';
      // when user cannot order because items are out of stock
    header('Location: cart.php');
  }

} elseif (isset($_POST['shipped'])) { // complete shipment
  $tranID = $_POST['tranID'];
  $staffID = $_POST['loginID'];
  $date = $_POST['shippedDate'];

  $myObj->compShipment($tranID, $staffID, $date);

}