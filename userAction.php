<?php

require_once('classes/crud.php');

$myObj = new CRUD;

// register
if (isset($_POST['register'])) { 
  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $bday = $_POST['bday'];
  $postal = $_POST['postal'];
  $address = $_POST['address'];
  $email = $_POST['email'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $confPass = $_POST['confPass'];
  $status = $_POST['status'];

  if ($password == $confPass) {
    $myObj->register($firstName, $lastName, $bday, $postal ,$address, $email, $username, $password, $status);
  } else {
    start();
    $_SESSION['message'] = "Your password and confirmation password don't match.";
    $_SESSION['color'] = 'text-success';
    if ($status == 'A') {
      header('Location: registerAdmin.php');
    } else {
      header('Location: register.php');
    }
  }
} 

// login
elseif (isset($_POST['login'])) { 
  $username = $_POST['username'];
  $password = $_POST['password'];

  $myObj->login($username, $password);
} 

// update user profile
elseif (isset($_POST['updateUser'])) { 
  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $postal = $_POST['postal'];
  $address = $_POST['address'];
  $email = $_POST['email'];
  $loginID = $_POST['loginID'];
  $status = $_POST['status'];

  $myObj->updateUser($firstName, $lastName, $postal, $address, $email, $loginID, $status);
} 

// add item information
elseif (isset($_POST['addItem'])) { 
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
    start();
    $_SESSION['message'] = "Item added.";
    $_SESSION['color'] = 'text-success';
    header("Location: addItem.php");
  } else {
    start();
    $_SESSION['message'] = "Error in adding an item.";
    $_SESSION['color'] = 'text-danger';
    header("Location: addItem.php");
  }
} 

// get selected item information
elseif (isset($_POST['getItem'])) { 
  $itemID = $_POST['itemID'];
  $_SESSION['itemID'] = $itemID;

  header('Location: updateItem.php');

} 

// update item information
elseif (isset($_POST['updateItem'])) { 
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
    start();
    $_SESSION['message'] = "Item information has been changed.";
    $_SESSION['color'] = 'text-success';
    header('Location: updateItem.php');
  } else {
    start();
    $_SESSION['message'] = "Error in updating an item.<br>";
    $_SESSION['color'] = 'text-danger';
    header('Location: updateItem.php');
  }
} 

// update password for user
elseif (isset($_POST['updatePassw'])) { 
  $loginID = $_POST['loginID'];
  $currentPassw = $_POST['currentPassw'];
  $newPassw = $_POST['newPassw'];
  $confPassw = $_POST['confPassw'];

  $result = $myObj->getCurrentPassw($loginID);

  if (password_verify($currentPassw, $result['password'])) {
    if ($newPassw == $confPassw) {
      $myObj->updatePassw($loginID, $newPassw);
    } else {
      start();
      $_SESSION['message'] = "New Password and Confirmation Password do not match.";
      $_SESSION['color'] = 'text-danger';
      header('Location: updatePassw.php');
    }
  } else {
    start();
    $_SESSION['message'] = "Your current password was incorrect.";
    $_SESSION['color'] = 'text-danger';
    header('Location: updatePassw.php');
  }
} 

// update Admin password
elseif (isset($_POST['updateAdminPassw'])) { 
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
      start();
      $_SESSION['message'] = "New Password and Confirmation Password do not match.";
      $_SESSION['color'] = 'text-danger';
      header('Location: updateAdminPassw.php');
    }
  } else {
    start();
    $_SESSION['message'] = "The admin current password was incorrect.";
    $_SESSION['color'] = 'text-danger';
    header('Location: updateAdminPassw.php');
  }
} 

// delete Admin account temporarily
elseif (isset($_POST['deleteAdmin'])) { 
  $userID = $_POST['userID'];

  $myObj->deleteAdmin($userID);
} 

// restore Admin account temporarily
elseif (isset($_POST['restoreAdmin'])) { 
  $userID = $_POST['userID'];

  $myObj->restoreAdmin($userID);
} 

// put item into cart
elseif (isset($_POST['putItem'])) { 
  $loginID = $_POST['loginID'];
  $itemID = $_POST['itemID'];

  if (empty($loginID)) {
    start();
    $_SESSION['message'] = "If you would like to purchase items online, please login.";
    $_SESSION['color'] = "text-warning";
    header('Location: login.php');
  } else {
    $myObj->insertItem($loginID, $itemID);
  }
} 

// delete item from cart
elseif(isset($_POST['deleteItem'])) { 
  $calcID = $_POST['calcID'];

  $myObj->deleteItemFromCart($calcID);

} 

// update items' quantity and grind 
elseif (isset($_POST['updateCalc'])) { 
  $calcID = $_POST['calcID'];
  $calcQuan = $_POST['calcQuan'];
  $grind = $_POST['grind'];

  $myObj->updateItemFromCart($calcID, $calcQuan, $grind);
} 

// order items
elseif (isset($_POST['order'])) { 
  $loginID = $_POST['loginID'];
  $totalPay = $_POST['totalPay'];
  $calcIDs = $_POST['calcIDs'];

  $ansForCheck = $myObj->checkQuan($calcIDs); 
    // check whether stock is enough or not

  if ($ansForCheck == count($calcIDs)) {
    $ansForOrder = $myObj->order($loginID, $totalPay);
      // insert information into 'transactions' table
    if ($ansForOrder[0] == 1) {
      $tranID = $ansForOrder[1];
      $myObj->updateStatusForCalc($calcIDs, $tranID);  
        // update calc_status from 'I' to 'O' , 'I': 'In process', 'O': 'Ordered' 
    }
  } else {
    start();
    $_SESSION['message'] = 
      "The stock of ". $row['item_name'] ." isn't enough. <br>
      Only ". $row['item_quantity'] ."00g left.<br> 
      Sorry for the inconvenience.";
    $_SESSION['color'] = 'text-danger';
      // when user cannot order because items are out of stock
    header('Location: cart.php');
  }
} 

// complete shipment
elseif (isset($_POST['shipped'])) { 
  $tranID = $_POST['tranID'];
  $staffID = $_POST['loginID'];
  $date = $_POST['shippedDate'];

  $myObj->compShipment($tranID, $staffID);
} 

// reorder
elseif (isset($_POST['reorder'])) {  
  $loginID = $_POST['loginID'];
  $calcIDs = $_POST['calcIDs'];

  // check there are enough stock by calc_id(s)
  $ansForCheck = $myObj->checkQuanForReorder($calcIDs);

  if ($ansForCheck[0] == count($calcIDs)) {
    $myObj->insertItemForReorder($loginID, $calcIDs);

  } else {
    $messages = [];
    foreach ($ansForCheck[1] as $name) {
      $messages[] = "The stock of " . $name . " is out of stock.";
    }
    $messages[] = "Sorry for the inconvenience.";
    $errorMessages = implode("<br>", $messages);
    start();
    $_SESSION['message'] = $errorMessages;
    $_SESSION['color'] = "text-danger";
    header('Location: history.php');
  }

}

