<?php

require_once('classes/crud.php');

$loginID = $_SESSION['login_id'];
$_SESSION['message'] = [];
$_SESSION['color'] = "";

$user = new CRUD;
$result = $user->getUser($loginID);

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
<title>Dashboard</title>
<style>
  body {
    background-color: white;
  }
</style>
</head>
<body>

  <?php include('navbar.php') ?>

  <main class="font-weight-light">
    <div class="container-fluid text-white font-weight-lighter h1 mb-0">
      <div class="jumbotron-fluid bg-primary py-5">
        <i class="fas fa-cog pl-4"></i>
        <p class="font-weight-lighter  d-inline-block m-0 pl-2">Dashboard</p>
      </div>
    </div>

    <div class="container-fluid mb-5">
      <div class="jumbotron-fluid bg-light py-5 text-center">
        <a href="addPost.php" class="bg-primary text-white rounded py-2 px-5 text-decoration-none">
          <span class="font-weight-bold h5">+</span> Add New Post
        </a>
        <a href="categoriesPage.php" class="bg-success text-white rounded py-2 px-5 mx-4 text-decoration-none">
          <span class="font-weight-bold h5">+</span> Add New Category
        </a>
        <a href="usersPage.php" class="bg-warning text-white rounded py-2 px-5 text-decoration-none">
          <span class="font-weight-bold h5">+</span> Add New User
        </a>
      </div>
    </div>

    <!-- display posts part -->
    <div class="container-fluid row justify-content-center m-0">
      <div class="col d-flex align-items-center text-dark" style="height:3rem;">
        <i class="fas fa-edit" ></i> Posts
      </div>

      <table class="table table-striped table-hover">
        <thead class="thead-dark">
          <tr>
            <th>Post ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Category</th>
            <th>Date Posted</th>
            <th></th>
          </tr>
        </thead>

        <!-- $result = getPostsForAdmin(); -->
        <!-- while ($row = $result->fetch_assoc()) -->
          <tr>
            <td class="align-middle"></td>
            <td class="align-middle"></td>
            <td class="align-middle"></td>
            <td class="align-middle"></td>
            <td class="align-middle"></td>
            <td>
              <form action="" method="post">
                <input type="hidden" name="post_id" value="">
                <input type="hidden" name="category_id" value="">
                <button type="submit" name="detail" class="btn btn-outline-dark">&raquo Details</button>
              </form>
            </td>
          </tr>
      </table>
    </div>
  </main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>