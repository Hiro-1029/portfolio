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

  if ($password == $confPass) {
    $myObj->insertToTable($firstName, $lastName, $bday, $address, $email, $username, $password);
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
 
}