<?php

session_start();

ini_set('display_errors', '1');

require_once('database.php');

class CRUD extends Database {
  
  // register user data to table
  public function register($firstName, $lastName, $bday, $address, $email, $username, $password, $status) {
    $sqlCheck1 = "SELECT * FROM login WHERE username = '$username' ";
    $sqlCheck2 = "SELECT * FROM login";
    $res1 = $this->conn->query($sqlCheck1);
    $res2 = $this->conn->query($sqlCheck2);
    $newPassw = password_hash($password, PASSWORD_DEFAULT);

    if ($res1->num_rows != 0) {// the case which there is same username in database
      $_SESSION['start'] = time();
      $_SESSION['expire'] = $_SESSION['start'] + 0.1;
      $_SESSION['message'] = 'The username already exists. Change your username.';
      $_SESSION['color'] = 'text-danger';
      if ($status == 'A') {
        header('Location: registerAdmin.php');
      } else {
        header('Location: register.php');
      }
    } else {
      if ($res2->num_rows == 0) {// for initial register
        $sql1 = "INSERT INTO login(username, password, status) VALUES ('$username', '$newPassw', 'S')";

        if ($this->conn->query($sql1)) {
          $lastID = $this->conn->insert_id;
          $sql2 = "INSERT INTO user(first_name, last_name, bday, address, email, picture, login_id) VALUES ('$firstName', '$lastName', '$bday', '$address', '$email', 'avatar.jpg', '$lastID')";

          if ($this->conn->query($sql2)) {
            $_SESSION['start'] = time();
            $_SESSION['expire'] = $_SESSION['start'] + 0.1;
            $_SESSION['message'] = "Your profile registered as Super Admin.";
            $_SESSION['color'] = "text-success";
            header('Location: login.php');
          } else {
            $_SESSION['start'] = time();
            $_SESSION['expire'] = $_SESSION['start'] + 0.1;
            $_SESSION['message'] = 'Error in inserting your data. ' . $this->conn->error;
            $_SESSION['color'] = 'text-danger';
            header('Location: register.php');
          }
        } else {
          $_SESSION['start'] = time();
          $_SESSION['expire'] = $_SESSION['start'] + 0.1;
          $_SESSION['message'] = 'Error in inserting your data. ' . $this->conn->error;
          $_SESSION['color'] = 'text-danger';
          header('Location: register.php');
        }
      } else {// for second register onward
        if ($status == 'A') {
          $sql1 = "INSERT INTO login(username, password, status) VALUES ('$username', '$newPassw', '$status')";
        } else {
          $sql1 = "INSERT INTO login(username, password, status) VALUES ('$username', '$newPassw', 'U')";
        }
  
        if ($this->conn->query($sql1)) {
          $lastID = $this->conn->insert_id;
  
          $sql2 = "INSERT INTO user(first_name, last_name, bday, address, email, picture, login_id) VALUES ('$firstName', '$lastName', '$bday', '$address', '$email', 'avatar.jpg', '$lastID')";
  
          if ($this->conn->query($sql2)) {
            $_SESSION['start'] = time();
            $_SESSION['expire'] = $_SESSION['start'] + 0.1;
            $_SESSION['message'] = "Your profile registered successfully.";
            $_SESSION['color'] = "text-success";
            header('Location: login.php');
          } else {
            $_SESSION['start'] = time();
            $_SESSION['expire'] = $_SESSION['start'] + 0.1;
            $_SESSION['message'] = 'Error in inserting your data. ' . $this->conn->error;
            $_SESSION['color'] = 'text-danger';
            if ($status == 'A') {
              header('Location: registerAdmin.php');
            } else {
              header('Location: register.php');
            }
          }
        } else {
          $_SESSION['start'] = time();
          $_SESSION['expire'] = $_SESSION['start'] + 0.1;
          $_SESSION['message'] = 'Error in inserting your data. ' . $this->conn->error;
          $_SESSION['color'] = 'text-danger';
          if ($status == 'A') {
            header('Location: registerAdmin.php');
          } else {
            header('Location: register.php');
          }
        }
      }
    }
  }

  // to login
  public function login($username, $password) {
    $sql = "SELECT * FROM login WHERE username = '$username' ";
    $result = $this->conn->query($sql);

    if ($result->num_rows == 1) {
      $row = $result->fetch_assoc();

      if(password_verify($password, $row['password'])) {
        $_SESSION['userame'] = $row['username'];
        $_SESSION['login_id'] = $row['login_id'];
        
        if ($row['status'] == 'S' || $row['status'] == 'A') {
          header('Location: dashboard.php');
        } elseif ($row['status'] == 'R') {
          header('Location: logout.php');
        } else {
          header('Location: userProfile.php');
        }
      } else {
        $_SESSION['start'] = time();
        $_SESSION['expire'] = $_SESSION['start'] + 0.1;
        $_SESSION['color'] = "text-danger";
        $_SESSION['message'] = "Error found. Check your username and password.";
        header('Location: login.php');
      }
    } else {
      $_SESSION['start'] = time();
      $_SESSION['expire'] = $_SESSION['start'] + 0.1;
      $_SESSION['color'] = "text-danger";
      $_SESSION['message'] = "Your username wasn't found.";
      header('Location: login.php');
    }
  }

  // get user infomation
  public function getUser($loginID) {
    $sql = "SELECT * FROM login JOIN user ON login.login_id = user.login_id WHERE login.login_id = '$loginID' ";

    if ($result = $this->conn->query($sql)) {
      return $result->fetch_assoc();
    }
  }

  /// get user information to update admin password
  // public function getUserByUserID($userID) {
  //   $sql = "SELECT * FROM login JOIN user ON login.login_id = user.login_id WHERE user.user_id = '$userID' ";

  //   if ($result = $this->conn->query($sql)) {
  //     return $result->fetch_assoc();
  //   }
  // }

  // get all standard users information 
  public function getAllUsers() {
    $sql = "SELECT * FROM login JOIN user ON login.login_id = user.login_id WHERE login.status = 'U' ";

    $result = $this->conn->query($sql);
    $rows = [];

    while ($row = $result->fetch_assoc()) {
      $rows[] = $row;
    }
    return $rows;
  }

  // get all adminUsers information
  // public function getAllAdminUsers() {
  //   $sql = "SELECT * FROM login JOIN user ON login.login_id = user.login_id WHERE login.status = 'A' ";

  //   $result = $this->conn->query($sql);
  //   $rows = [];

  //   while ($row = $result->fetch_assoc()) {
  //     $rows[] = $row;
  //   }
  //   return $rows;
  // }

  // get selected adminusers information
  public function getSelectedAdminUsers($status) {
    $sql = "SELECT * FROM login JOIN user ON login.login_id = user.login_id WHERE login.status = '$status' ";

    $result = $this->conn->query($sql);
    $rows = [];

    while ($row = $result->fetch_assoc()) {
      $rows[] = $row;
    }
    return $rows;
  }

  // update user profile
  public function updateUser($firstName, $lastName, $address, $email, $loginID, $status) {
    $sql = "UPDATE user INNER JOIN login ON user.login_id = login.login_id
      SET
        user.first_name = '$firstName', 
        user.last_name = '$lastName', 
        user.address = '$address', 
        user.email = '$email'
      WHERE login.login_id = '$loginID' ";
    
    if ($this->conn->query($sql)) {
      $_SESSION['start'] = time();
      $_SESSION['expire'] = $_SESSION['start'] + 0.1;
      $_SESSION['color'] = "text-success";
      $_SESSION['message'] = "Your profile updated successfully.";
      if ($status == 'A') {
        header('Location: updateAdmin.php');
      } else {
        header('Location: userProfile.php');
      }
    } else {
      $_SESSION['start'] = time();
      $_SESSION['expire'] = $_SESSION['start'] + 0.1;
      $_SESSION['message'] = 'Uploading error found.';
      $_SESSION['color'] = 'text-danger';
      if ($status == 'A') {
        header('Location: updateAdmin.php');
      } else {
        header('Location: updateProfile.php');
      }
    }
  }

  // add item
  public function addItem($itemName, $itemPrice, $itemQuantity, $roast, $itemDesc, $itemPicture) {
    $sql = "INSERT INTO items(item_name, item_price, item_quantity, roast_level, item_desc, item_picture) VALUES ('$itemName', '$itemPrice', '$itemQuantity', '$roast', '$itemDesc', '$itemPicture' )";

    if ($this->conn->query($sql)) {
      return 1;
    } else {
      return 0;
    }
  }

  // show all items you chose
  public function getItems($status) {
    if ($status == 'A') {
      $sql = "SELECT * FROM items";
    } elseif ($status == 'S') {
      $sql = "SELECT * FROM items WHERE item_status LIKE 'S%' ";
    } else {
      $sql = "SELECT * FROM items WHERE item_status = '$status' ";
    }

    $result = $this->conn->query($sql);
    $rows = [];

    while ($row = $result->fetch_assoc()) {
      $rows[] = $row;
    }
    return $rows;
  }

  // get an item information
  public function getItem($itemID) {
    $sql = "SELECT * FROM items WHERE item_id = '$itemID' ";

    if ($result = $this->conn->query($sql)) {
      return $result->fetch_assoc();
    }
  }

  // update item information
  public function updateItem($itemID, $itemName, $itemPrice, $itemQuantity, $roast, $itemDesc, $itemPicture, $itemStatus) {
    if ($itemPicture == "") {
      $sql = "UPDATE items 
      SET
        item_name = '$itemName', 
        item_price = '$itemPrice', 
        item_quantity = '$itemQuantity', 
        item_desc = '$itemDesc', 
        roast_level = '$roast', 
        item_status = '$itemStatus'  
      WHERE item_id = '$itemID' ";
    } else {
    $sql = "UPDATE items 
      SET
        item_name = '$itemName', 
        item_price = '$itemPrice', 
        item_quantity = '$itemQuantity', 
        item_desc = '$itemDesc', 
        roast_level = '$roast', 
        item_picture = '$itemPicture' , 
        item_status = '$itemStatus'  
      WHERE item_id = '$itemID' ";
    }
    
    if ($this->conn->query($sql)) {
      return 1;
    } else {
      return 0;
    }
  }

  // get user current password
  public function getCurrentPassw($loginID) {
    $sql = "SELECT * FROM login WHERE login_id = '$loginID' ";

    if ($result = $this->conn->query($sql)) {
      return $result->fetch_assoc();
    }
  }

  // update user password
  public function updatePassw($loginID, $newPassw) {
    $newPasswHashed = password_hash($newPassw, PASSWORD_DEFAULT);
    $sql = "UPDATE login SET password = '$newPasswHashed' WHERE login_id = '$loginID' ";

    $sqlCheck = "SELECT * FROM login JOIN user ON login.login_id = user.login_id WHERE login.login_id = '$loginID' ";

    if ($result = $this->conn->query($sqlCheck)) {
      $row = $result->fetch_assoc();
    }

    if ($this->conn->query($sql)) {
      $_SESSION['start'] = time();
      $_SESSION['expire'] = $_SESSION['start'] + 0.1;
      $_SESSION['message'] = "Your Password changed. <br> Please don't forget to make a note.";
      $_SESSION['color'] = 'text-success';
      if ($row['status'] == 'A') {
        header('Location: updateAdminPassw.php');
      } else {
        header('Location: userProfile.php');
      }
    } else {
      $_SESSION['start'] = time();
      $_SESSION['expire'] = $_SESSION['start'] + 0.1;
      $_SESSION['message'] = "Your Password hasn't changed.";
      $_SESSION['color'] = 'text-danger';
      if ($row['status'] == 'A') {
        header('Location: updateAdminPassw.php');
      } else {
        header('Location: userProfile.php');
      }
    }
  }

  // delete Admin temporarily
  public function deleteAdmin($userID) {
    $sql = "UPDATE login SET status = 'R' WHERE login_id = '$userID' ";
      // 'R' -> 'Remove Temporarily'
    if ($this->conn->query($sql)) {
      $_SESSION['start'] = time();
      $_SESSION['expire'] = $_SESSION['start'] + 0.1;
      $_SESSION['message'] = "The selected admin user was removed.";
      $_SESSION['color'] = 'text-success';
      header('Location: showAdminUsers.php');
    } else {
      $_SESSION['start'] = time();
      $_SESSION['expire'] = $_SESSION['start'] + 0.1;
      $_SESSION['message'] = "The selected admin user wasn't removed.";
      $_SESSION['color'] = 'text-danger';
      header('Location: showAdminUsers.php');
    }
  }

  // restore Admin temporarily
  public function restoreAdmin($userID) {
    $sql = "UPDATE login SET status = 'A' WHERE login_id = '$userID' ";
      // 'R' -> 'Remove Temporarily'
    if ($this->conn->query($sql)) {
      $_SESSION['start'] = time();
      $_SESSION['expire'] = $_SESSION['start'] + 0.1;
      $_SESSION['message'] = "The selected admin user was restored.";
      $_SESSION['color'] = 'text-success';
      header('Location: showAdminUsers.php');
    } else {
      $_SESSION['start'] = time();
      $_SESSION['expire'] = $_SESSION['start'] + 0.1;
      $_SESSION['message'] = "The selected admin user wasn't restored.";
      $_SESSION['color'] = 'text-danger';
      header('Location: showAdminUsers.php');
    }
  }

  // put item information into calc table at once
  public function insertItem($loginID, $itemID) {
    $sqlCheck1 = "SELECT * FROM items WHERE item_id = '$itemID' ";
      // check whether stock is more than 1

    if ($result = $this->conn->query($sqlCheck1)) {
      $row = $result->fetch_assoc();
      if ($row['item_quantity'] = 0) {
        $_SESSION['start'] = time();
        $_SESSION['expire'] = $_SESSION['start'] + 0.1;
        $_SESSION['message'] = $row['item_name'] ." is out of stock now. <br> Sorry for the inconvenience.";
        $_SESSION['color'] = 'text-danger';
        header('Location: cart.php');
      }
    }

    $sqlCheck2 = "SELECT * FROM calc WHERE login_id = $loginID AND item_id = $itemID AND calc_status = 'I' ";
      // check whether the login users already have this item in their carts
      // 'I' means 'In Process'

    $res = $this->conn->query($sqlCheck2);

    if ($res->num_rows > 0) {
      $_SESSION['start'] = time();
      $_SESSION['expire'] = $_SESSION['start'] + 0.1;
      $_SESSION['message'] = 'This item is already in your cart.';
      $_SESSION['color'] = 'text-danger';
      header('Location: cart.php');
    } else { // the case which user doesn't have this item in his or her cart
      $sql = "INSERT INTO calc(login_id, item_id) VALUES ('$loginID', '$itemID')";
  
      if ($this->conn->query($sql)) {
        header('Location: cart.php'); 
      } else {
        $_SESSION['start'] = time();
        $_SESSION['expire'] = $_SESSION['start'] + 0.1;
        $_SESSION['message'] = "The item couldn't be added into your cart.";
        $_SESSION['color'] = "text-danger";
        header('Location: cart.php');
      }
    }

  }

  // show cart information
  public function getCartItems($loginID, $calcStat) {
    $sql = "SELECT * FROM calc JOIN items ON calc.item_id = items.item_id WHERE login_id = '$loginID' AND calc_status = '$calcStat' ";

    $result = $this->conn->query($sql);
    $rows = [];

    while ($row = $result->fetch_assoc()) {
      $rows[] = $row;
    }
    return $rows;
  }

  // delete item from cart
  public function deleteItemFromCart($calcID) { 
    $sql = "UPDATE calc SET calc_status = 'D' WHERE calc_id = '$calcID' "; // 'D' means 'Delete' here

    if ($this->conn->query($sql)) {
      header('Location: cart.php');
    } else {
      $_SESSION['start'] = time();
      $_SESSION['expire'] = $_SESSION['start'] + 0.1;
      $_SESSION['message'] = "Item couldn't be deleted.";
      $_SESSION['color'] = 'text-danger';
      header('Location: cart.php');
    }
  }

  // update item information in cart
  public function updateItemFromCart($calcID, $calcQuan, $grind) { 
    $sqlCheck = "SELECT * FROM calc JOIN items on calc.item_id = items.item_id WHERE calc_id = '$calcID' "; // check whether stock is enough before update quantity

    if ($result = $this->conn->query($sqlCheck)) {
      $row = $result->fetch_assoc();

      if ($row['item_quantity'] >= $calcQuan) { // stock is enough
        $sql = "UPDATE calc SET calc_quan = '$calcQuan', grind = '$grind' WHERE calc_id = '$calcID' ";

        if ($this->conn->query($sql)) {
          $_SESSION['start'] = time();
          $_SESSION['expire'] = $_SESSION['start'] + 0.1;
          $_SESSION['message'] = "Item information was changed.";
          $_SESSION['color'] = 'text-success';
          header('Location: cart.php');
        } else {
          $_SESSION['start'] = time();
          $_SESSION['expire'] = $_SESSION['start'] + 0.1;
          $_SESSION['message'] = "Item couldn't be changed.";
          $_SESSION['color'] = 'text-danger';
          header('Location: cart.php');
        }
      } else { // stock isn't enough
        $_SESSION['start'] = time();
        $_SESSION['expire'] = $_SESSION['start'] + 0.1;
        $_SESSION['message'] = 
          "The stock of ". $row['item_name'] ." isn't enough. <br>
          Only ". $row['item_quantity'] ."00g left.<br> 
          Sorry for the inconvenience.";
        $_SESSION['color'] = 'text-danger';
        header('Location: cart.php');
      }
    }    
  }

  // check whether there are enough stocks before user order
  public function checkQuan($calcIDs) {
    $count = 0;

    foreach ($calcIDs as $id) { // check whether each item has enough stock
      $sql = "SELECT * FROM calc JOIN items on calc.item_id = items.item_id WHERE calc_id = '$id' "; 

      if ($result = $this->conn->query($sql)) {
        $row = $result->fetch_assoc();
        if ($row['item_quantity'] >= $row['calc_quan']) {
          $count += 1;
        }
      }
    }
    return $count;
  }

  // order item
  public function order($loginID, $totalPay) {
    $sql= "INSERT INTO transactions (login_id, total_pay, tran_date, tran_status) VALUES ('$loginID', '$totalPay', now(), 'I')"; // 'I' means 'In Process'

    if ($this->conn->query($sql)) {
      $result = $this->conn->insert_id;
      $resultToReturn = [1, $result];
      return $resultToReturn;
      
    } else {
      $_SESSION['start'] = time();
      $_SESSION['expire'] = $_SESSION['start'] + 0.1;
      $_SESSION['message'] = "Error ordering.";
      $_SESSION['color'] = "text-danger";
      header('Location: cart.php');
    }
  }

  // update calc_status from 'I' to 'O' , 'I': In Process, 'O': ordered 
  // and reduce the ordered items' quantity
  public function updateStatusForCalc($calcIDs, $tranID) {
    foreach ($calcIDs as $id) {
      $sqlSelect = "SELECT * FROM calc JOIN items on calc.item_id = items.item_id WHERE calc_id = '$id' ";

      if ($result = $this->conn->query($sqlSelect)) {
        $row = $result->fetch_assoc();
        $newQuan = $row['item_quantity'] - $row['calc_quan'];
      }

      if ($newQuan == 0) {
        if ($row['item_status'] == 'N') {
          $sqlUpdate = "UPDATE calc JOIN items ON calc.item_id = items.item_id 
          SET 
            calc.calc_status = 'O', 
            items.item_quantity = '$newQuan', 
            calc.tran_id = '$tranID', 
            items.item_status = 'SN'
          WHERE calc.calc_id = '$id' ";
        } elseif ($row['item_status'] == 'E') {
          $sqlUpdate = "UPDATE calc JOIN items ON calc.item_id = items.item_id 
            SET 
              calc.calc_status = 'O', 
              items.item_quantity = '$newQuan', 
              calc.tran_id = '$tranID', 
              items.item_status = 'SE'
            WHERE calc.calc_id = '$id' ";
        }
      } else {
        $sqlUpdate = "UPDATE calc JOIN items ON calc.item_id = items.item_id 
          SET 
            calc.calc_status = 'O', 
            items.item_quantity = '$newQuan', 
            calc.tran_id = '$tranID'
          WHERE calc.calc_id = '$id' ";
      }
      
      if ($this->conn->query($sqlUpdate)) {
        $_SESSION['start'] = time();
        $_SESSION['expire'] = $_SESSION['start'] + 0.1;
        $_SESSION['message'] = "You items were ordered. <br> Please look forward to the arrival.";
        $_SESSION['color'] = "text-success";
        header('Location: cart.php');
      }
    }
  }
  
  // get transaction data by tran_id
  public function getTran($tranID) {
    $sql = "SELECT * FROM transactions WHERE tran_id = '$tranID' ";

    if ($result = $this->conn->query($sql)) {
      return $result->fetch_assoc();
    }
  }

  // show transactions not to have been sent yet
  public function getTrans($tranStatus) {
    // if ($tranStatus == 'S') { 
      if ($tranStatus == 'S' || $tranStatus == 'SN' || $tranStatus == 'SE') { 
        // 'SN' -> 'Sold out after New', 'SE' -> 'Sold our after Existing'
        // preg_match('/S/', $tranStatus);
      $sql = "SELECT * FROM transactions WHERE tran_status = '$tranStatus' ORDER BY tran_id DESC";
    } else {
      $sql = "SELECT * FROM transactions WHERE tran_status = '$tranStatus' ";
    }

    $result = $this->conn->query($sql);
    $rows = [];

    while ($row = $result->fetch_assoc()) {
      $rows[] = $row;
    }
    return $rows;
  }

  // show transaction details from calc table and items table
  public function getTranDetails($tranID) {
    $sql = "SELECT * FROM calc
      JOIN items ON calc.item_id = items.item_id 
      WHERE tran_id = '$tranID' ";
    
    $result = $this->conn->query($sql);
    $rows = [];

    while ($row = $result->fetch_assoc()) {
      $rows[] = $row;
    }
    return $rows;

  }

  // complete shipment
  public function compShipment($tranID, $staffID) {
    $sqlForTran = "UPDATE transactions 
      SET 
        tran_status = 'S', 
        staff_id = '$staffID', 
        shipped_date = now() 
       WHERE tran_id = '$tranID' ";
        
    $sqlForCalc = "UPDATE calc SET calc_status = 'C' WHERE tran_id = '$tranID' ";
      // transactions: tran_status -> S(hipped), shipped_date, staff_id
      // calc: calc_status O->C(omplete)

    if ($this->conn->query($sqlForTran)) {
      if ($this->conn->query($sqlForCalc)) {
        $_SESSION['start'] = time();
        $_SESSION['expire'] = $_SESSION['start'] + 0.1;
        $_SESSION['message'] = "This order was shipped.";
        $_SESSION['color'] = "text-success";
        header('Location: showTrans.php');
      } else {
        $_SESSION['start'] = time();
        $_SESSION['expire'] = $_SESSION['start'] + 0.1;
        $_SESSION['message'] = "Error in Calc.";
        $_SESSION['color'] = "text-danger";
        header('Location: showTrans.php');
      }
    } else {
      $_SESSION['start'] = time();
      $_SESSION['expire'] = $_SESSION['start'] + 0.1;
      $_SESSION['message'] = "Error in Transactions.";
      $_SESSION['color'] = "text-danger";
      header('Location: showTrans.php');
    }
  }

  // show user transaction history
  public function getTransForHistory($loginID) {
    $sql = "SELECT * FROM transactions WHERE login_id = '$loginID' ORDER BY tran_id DESC";
    $result = $this->conn->query($sql);
    $rows = [];

    while ($row = $result->fetch_assoc()) {
      $rows[] = $row;
    }
    return $rows;
  }

  // cancel order which wasn't shipped yet
  public function cancel($tranID) {
    $sqlForTran = "UPDATE transactions SET tran_status = 'R' WHERE tran_id = '$tranID' ";
      // 'R' -> 'Removed'

    $sqlCheck = "SELECT * FROM calc JOIN items ON calc.item_id = items.item_id WHERE tran_id = '$tranID' ";
    $result = $this->conn->query($sqlCheck);
    $rows = [];
    while ($row = $result->fetch_assoc()) {
      $rows[] = $row;
    }
    
    $count = 0;
    $countRows = count($rows);
    
    if ($this->conn->query($sqlForTran)) {
      if ($this->conn->query($sqlCheck)) {
        foreach ($rows as $row) {
          $itemID = $row['item_id'];
          $itemQuan = $row['calc_quan'] + $row['item_quantity'];
    
          if ($row['item_status'] == 'SN') {
            $sqlForCal = "UPDATE calc JOIN items ON calc.item_id = items.item_id 
              SET
                calc.calc_status = 'R', 
                items.item_quantity = '$itemQuan',
                items.item_status = 'N'
              WHERE calc.item_id = '$itemID' ";
          } elseif ($row['item_status'] == 'SE') {
            $sqlForCal = "UPDATE calc JOIN items ON calc.item_id = items.item_id 
              SET
                calc.calc_status = 'R', 
                items.item_quantity = '$itemQuan',
                items.item_status = 'E'
              WHERE calc.item_id = '$itemID' ";
          } else {
            $sqlForCal = "UPDATE calc JOIN items ON calc.item_id = items.item_id 
              SET
                calc.calc_status = 'R', 
                items.item_quantity = '$itemQuan'
              WHERE calc.item_id = '$itemID' ";
          }
    
          if ($this->conn->query($sqlForCal)) {
            $count++;
            if ($count == $countRows) {
              $_SESSION['start'] = time();
              $_SESSION['expire'] = $_SESSION['start'] + 0.1;
              $_SESSION['message'] = "This order was canceled.";
              $_SESSION['color'] = "text-success";
              header('Location: history.php');
            }
          } 
        } // foreach ends here

      } else {
        $_SESSION['start'] = time();
        $_SESSION['expire'] = $_SESSION['start'] + 0.1;
        $_SESSION['message'] = "This order wan't canceled. <br> Please email us.";
        $_SESSION['color'] = "text-danger";
        header('Location: history.php');
      }
    } else {
      $_SESSION['start'] = time();
      $_SESSION['expire'] = $_SESSION['start'] + 0.1;
      $_SESSION['message'] = "This order wan't canceled. <br> Please email us.";
      $_SESSION['color'] = "text-danger";
      header('Location: history.php');
    }
  }


  

}