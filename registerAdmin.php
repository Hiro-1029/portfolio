<?php

require_once('classes/crud.php');

$loginID = $_SESSION['login_id'];
$_SESSION['message'] = [];
$_SESSION['color'] = "";

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
<title>Register Admin</title>
<style>
  body {
    background-color: white;
  }

  @media (max-width: 700px) {
    .editButton {
      display: block;
      margin: 30px 0 auto;
      text-align: center;
    }
}
</style>
</head>
<body>

  <?php include('parts/navbar.php') ?>

  <div class="container" data-aos="fade-up">    
    <div class="section-title text-center py-4">
      <p>Register Admin</p>
    </div>
  </div>
  
  <div class="container" data-aos="fade-up" style="padding-top:0;">
    <div class="w-50 mx-auto mt-lg-0 text-dark">

      <form action="userAction.php" method="post" class="register mb-5">
        <div class="form-row">
          <div class="col-md-6 form-group mx-auto">
            <label for="firstName">First Name</label>
            <input type="text" name="firstName" class="form-control" id="firstName" required>
            <div class="validate"></div>
          </div>
          <div class="col-md-6 form-group mx-auto">
            <label for="lastName">Last Name</label>
            <input type="text" name="lastName" class="form-control" id="lastName" required>
            <div class="validate"></div>
          </div>
        </div>
        
        <div class="form-row">
          <div class="col-md-6 form-group mx-auto">
            <label for="username">Username</label>
            <input type="text" name="username" class="form-control" id="username" required>
            <div class="validate"></div>
          </div>
          <div class="col-md-6 form-group mx-auto">
            <label for="bday">Start Date</label>
            <input type="date" name="bday" class="form-control" id="bday" required>
            <div class="validate"></div>
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-6 form-group mx-auto">
            <label for="address">Address</label>
            <input type="text" name="address" class="form-control" id="address" required>
            <div class="validate"></div>
          </div>
          <div class="col-md-6 form-group mx-auto">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" id="email" required>
            <div class="validate"></div>
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-6 form-group mx-auto">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" id="password" required>
            <div class="validate"></div>
          </div>
          <div class="col-md-6 form-group mx-auto mb-5">
            <label for="confPass">Confirmation Password</label>
            <input type="password" class="form-control" name="confPass" id="confPass" required>
            <div class="validate"></div>
          </div>
        </div>

        <input type="hidden" name="status" value="A">

        <input type="submit" name="register" value="Register" class="btn btn-block w-50 mx-auto" style="background:#bc8f8f;">
       
      </form>

    </div>
  </div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>