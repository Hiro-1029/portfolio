<?php

include('parts/header.php');

?>

<section id="hero" class="hero" style="padding-top:50px;">
  <div class="container" data-aos="fade-up">

    <?php if (!empty($message)): ?>
      <?= "<p class='pt-4 $color text-center' style='font-size: 20px;'>$message<br> </p>" ?>
    <?php endif ?>

    <div class="section-title text-center">
      <p>Change Password</p>
    </div>
  </div>

  <div class="container" data-aos="fade-up" style="padding-top:0;">

    <div class="w-50 mx-auto my-4 mt-lg-0">

      <form action="userAction.php" method="post" class="mb-5">
        <div class="col-md-6 form-group mx-auto">
          <label for="currentPassw">Current Password</label>
          <input type="password" id="currentPassw" name="currentPassw" class="form-control mb-2" required>
          <div class="validate"></div>
        </div>

        <div class="col-md-6 form-group mx-auto">
          <label for="newPassw">New Password</label>
          <input type="password" id="newPassw" name="newPassw" class="form-control mb-2" required>
          <div class="validate"></div>
        </div>

        <div class="col-md-6 form-group mx-auto">
          <label for="confPassw">Confirmation Password</label>
          <input type="password" id="confPassw" name="confPassw" class="form-control mb-2" required>
          <div class="validate"></div>
        </div>
        
        <input type="hidden" name="loginID" value="<?= $loginID ?>">

        <?php if (empty($message)): ?>
          <p class="h5 text-center text-danger mb-3">If you really want to change your password, change the button below.</p>
        <?php endif ?>

        <div id="login" class="text-center nav-menu mt-4">
          <input type="submit" name="updatePassw" value="Change" class="btn">
        </div>

      </form>

    </div>
  </div>
</section>

<?php

include('parts/footer.php');
