<?php

session_start();

ini_set('display_errors', '1');

require_once('database.php');

class CRUD extends Database {
  
  // register user data to table
  public function register($firstName, $lastName, $bday, $address, $email, $username, $password, $status) {
    $sql_check ="SELECT * FROM login WHERE username = '$username' ";
    $res = $this->conn->query($sql_check);
    if ($res->num_rows != 0) {
      $_SESSION['message'] = 'The username already exists. Change your username.';
      $_SESSION['color'] = 'text-danger';
    } else {
      $new_pass = md5($password);

      $sql1 = "INSERT INTO login(username, password, status) VALUES ('$username', '$new_pass', '$status')";

      if ($this->conn->query($sql1)) {
        $lastID = $this->conn->insert_id;

        $sql2 = "INSERT INTO user(first_name, last_name, bday, address, email, picture, login_id) VALUES ('$firstName', '$lastName', '$bday', '$address', '$email', 'avatar.jpg', '$lastID')";

        if ($this->conn->query($sql2)) {
          $_SESSION['message'] = "Your profile registered successfully.";
          $_SESSION['color'] = "text-success";
          $_SESSION['login_id'] = $lastID;
          header('Location: login.php');
        } else {
          $_SESSION['message'] = 'Error in inserting your data. ' . $this->conn->error;
          $_SESSION['color'] = 'text-danger';
          header('Location: register.php');
        }
      } else {
        $_SESSION['message'] = 'Error in inserting your data. ' . $this->conn->error;
        $_SESSION['color'] = 'text-danger';
        header('Location: register.php');
      }
    }
  }

  // to login
  public function login($username, $password) {
    $new_pass = md5($password);

    $sql = "SELECT * FROM login WHERE username = '$username' AND password = '$new_pass' ";
    $result = $this->conn->query($sql);

    if ($result->num_rows == 1) {
      $row = $result->fetch_assoc();

      $_SESSION['login_id'] = $row['login_id'];

      if ($row['status'] == 'U') {
        header('Location: updateUser.php');
      } else {
        header('Location: dashboard.php');
      }
    } else {
      $_SESSION['color'] = "text-danger";
      $_SESSION['message'] = "Error detected. Check your username and password.";
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
  public function getAllAdminUsers() {
    $sql = "SELECT * FROM login JOIN user ON login.login_id = user.login_id WHERE login.status = 'A' ";

    $result = $this->conn->query($sql);
    $rows = [];

    while ($row = $result->fetch_assoc()) {
      $rows[] = $row;
    }
    return $rows;
  }

  // update user profile
  public function updateUser($firstName, $lastName, $bday, $address, $email, $username, $loginID, $status) {
    $sql = "UPDATE user INNER JOIN login ON user.login_id = login.login_id
      SET
        user.first_name = '$firstName', 
        user.last_name = '$lastName', 
        user.bday = '$bday', 
        user.address = '$address', 
        user.email = '$email', 
        login.username = '$username' 
      WHERE login.login_id = '$loginID' ";
    
    if ($this->conn->query($sql)) {
      $_SESSION['color'] = "text-success";
      $_SESSION['message'] = "Your profile updated successfully.";
      if ($status == 'U') {
        header('Location: updateUser.php');
      } else {
        header('Location: updateAdmin.php');
      }
    } else {
      echo "Error in updating. " . $this->conn->error;
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




}