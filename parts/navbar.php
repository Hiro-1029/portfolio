<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"><span class="navbar-toggler-icon"></span></button>

  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active mr-2">
        <?php if (empty($loginID)): ?>
          <a href="index.php" class="nav-link">Home</a>
        <?php else: ?>
          <a href="indexForUser.php" class="nav-link">Home</a>
        <?php endif ?>
      </li>
      <li class="nav-item active mr-2">
        <a href="dashboard.php" class="nav-link">Dashboard</a>
      </li>
      <?php if ($result['status'] == 'S'): ?>
        <li class="nav-item active mr-2">
          <a href="showAdminUsers.php" class="nav-link">Admins</a>
        </li>
      <?php endif ?>
      <li class="nav-item active mr-2">
        <a href="showUsers.php" class="nav-link">Users</a>
      </li>
      <li class="nav-item active mr-2">
        <a href="showItems.php" class="nav-link">Items</a>
      </li>
      <li class="nav-item active mr-2">
        <a href="showTrans.php" class="nav-link">Transactions</a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item active mr-2">
        <?php if ($result['status'] == 'A'): ?>
          <a href="updateAdmin.php" class="nav-link">
            Hello, Admin <span class="text-info"><?= $result['username'] ?></span>
          </a>
        <?php else: ?>
          <a href="#" class="nav-link">
            Hello, Super Admin <span class="text-info"><?= $result['username'] ?></span>
          </a>
        <?php endif ?>
      </li>
      <li class="nav-item active mr-2">
        <a href="logout.php" class="nav-link">
          <i class="fas fa-user"></i>
          Logout
        </a>
      </li>
    </ul>
  </div>    
</nav>