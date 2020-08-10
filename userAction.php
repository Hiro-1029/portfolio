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
    header('Location: register.php');
  }

} elseif (isset($_POST['login'])) { // login
  $username = $_POST['username'];
  $password = $_POST['password'];

  $myObj->login($username, $password);

} elseif (isset($_POST['updateUser'])) { // update user profile
  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $bday = $_POST['bday'];
  $address = $_POST['address'];
  $email = $_POST['email'];
  $username = $_POST['username'];
  $loginID = $_POST['loginID'];
  $status = $_POST['status'];

  $myObj->updateUser($firstName, $lastName, $bday, $address, $email, $username, $loginID, $status);
 
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

} elseif (isset($_POST['updatePasswForUser'])) {
  // $userID = $_POST['userID'];


  // $myObj->updatePassw();

} elseif (isset($_POST['updatePasswForAdmin'])) {
  $userID = $_POST['userID'];


  $myObj->updatePassw();

} elseif (isset($_POST['deleteAdmin'])) {
  $userID = $_POST['userID'];

}