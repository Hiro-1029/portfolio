<?php

include('headerForUser.php');

?>

<section id="hero" class="hero" style="padding-top:50px;">
  <div class="container" data-aos="fade-up">

    <?php if (!empty($messages[0])): ?>
      <?= "<p class='pt-4 $color text-center' style='font-size: 20px;'>" ?>
        <?php foreach ($messages as $message): ?>
          <?= $message . "<br>" ?>
        <?php endforeach ?>
      </p>
    <?php endif ?>

    <div class="section-title text-center">
      <p>Login</p>
    </div>
  </div>

  <div class="container" data-aos="fade-up" style="padding-top:0;">

    <div class="w-50 mx-auto my-5 mt-lg-0">

      <form action="userAction.php" method="post" class="mb-5">
        <div class="col-md-6 form-group mx-auto">
          <input type="text" name="username" class="form-control" id="username" placeholder="Username" required>
          <div class="validate"></div>
        </div>

        <div class="col-md-6 form-group mx-auto mb-5">
          <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
          <div class="validate"></div>
        </div>
        
        <div class="text-center"><button type="submit" name="login">Login</button></div>
      </form>

      <?php if (empty($loginID)): ?>
        <p class="text-center">If you are not a member, please register.</p>
        <nav class="nav-menu d-none d-lg-block">
          <ul>
            <li class="book-a-table mx-auto" style="padding:0"><a href="register.php">Register</a></li>
          </ul>
        </nav>
      <?php endif ?>


    </div>
  </div>
</section>

<?php

include('footer.php');
