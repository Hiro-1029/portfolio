<?php

session_start();

ini_set('display_errors', '1');

require_once('database.php');

class CRUD extends Database {
  
  // register user data to table
  public function insertToTable($firstName, $lastName, $bday, $address, $email, $username, $password) {
    $sql_check ="SELECT * FROM login WHERE username = '$username' ";
    $res = $this->conn->query($sql_check);
    if ($res->num_rows != 0) {
      echo "Error: The username already exists. Change your username.";
    } else {
      $new_pass = md5($password);

      $sql1 = "INSERT INTO login(username, password) VALUES ('$username', '$new_pass')";

      if ($this->conn->query($sql1)) {
        $lastID = $this->conn->insert_id;

        $sql2 = "INSERT INTO user(first_name, last_name, bday, address, email, picture, login_id) VALUES ('$firstName', '$lastName', '$bday', '$address', '$email', 'avatar.jpg', '$lastID')";

        if ($this->conn->query($sql2)) {
          $_SESSION['message'] = "Your profile registered successfully.";
          $_SESSION['login_id'] = $lastID;
          header('Location: login.php');
        } else {
          echo "Error in inserting your data." . $this->conn->error;
        }
      } else {
        echo "Error in inserting your data." . $this->conn->error;
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
        header('Location: user.php');
      } elseif ($row['status'] == 'A') {
        header('Location: dashboard.php');
      } else {
        header('Location: superAdmin.php');
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

  // get all users information
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
        header('Location: user.php');
      } elseif ($status == 'A') {
        header('Location: profileAdmin.php');
      } else {
        header('Location: superAdmin.php');
      }
    } else {
      echo "Error in updating. " . $this->conn->error;
    }
  }



}