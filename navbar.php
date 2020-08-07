<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"><span class="navbar-toggler-icon"></span></button>

  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active mr-2">
        <a href="dashboard.php" class="nav-link">Dashboard</a>
      </li>
      <li class="nav-item active mr-2">
        <a href="showAdminUsers.php" class="nav-link">Admins</a>
      </li>
      <li class="nav-item active mr-2">
        <a href="showUsers.php" class="nav-link">Users</a>
      </li>
      <li class="nav-item active mr-2">
        <a href="" class="nav-link"></a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item active mr-2">
        <a href="profileAdmin.php" class="nav-link">
          Hello: <?= $result['username'] ?>
        </a>
      </li>
      <li class="nav-item active mr-2">
        <a href="logout.php" class="nav-link">
          <i class="fas fa-user"></i>
          *Logout
        </a>
      </li>
    </ul>
  </div>    
</nav>