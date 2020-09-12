<?php

include('parts/header.php');
        
?>

<section id="hero" class="hero" style="padding-top:30px;">
  <div class="container" data-aos="fade-up">

    <?php if (!empty($message)): ?>
      <?= "<p class='pt-4 $color text-center' style='font-size: 20px;'>$message<br> </p>" ?>
    <?php endif ?>

    <div class="section-title text-center py-2">
      <p>Register</p>
    </div>
  </div>
  
  <div class="container" data-aos="fade-up" style="padding-top:0;">
    <div class="w-50 mx-auto mt-lg-0">

      <form action="userAction.php" method="post" class="register mb-5">
        <div class="form-row">
          <div class="col-md-4 form-group mx-auto">
            <label for="firstName">First Name</label>
            <input type="text" name="firstName" class="form-control" id="firstName" required>
            <div class="validate"></div>
          </div>
          <div class="col-md-4 form-group mx-auto">
            <label for="lastName">Last Name</label>
            <input type="text" name="lastName" class="form-control" id="lastName" required>
            <div class="validate"></div>
          </div>
          <div class="col-md-4 form-group mx-auto">
            <label for="username">Username</label>
            <input type="text" name="username" class="form-control" id="username" required>
            <div class="validate"></div>
          </div>
        </div>

        
        
        <div class="form-row">
          
          <div class="col-md-6 form-group mx-auto">
            <label for="bday">Birthday</label>
            <input type="date" name="bday" class="form-control" id="bday" required>
            <div class="validate"></div>
          </div>
          <div class="col-md-6 form-group mx-auto">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" id="email" required>
            <div class="validate"></div>
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-4 form-group mx-auto">
            <label for="postal">Postal Code</label>
            <input type="text" name="postal" placeholder="1234567" maxlength="7" class="form-control" required onKeyUp="AjaxZip3.zip2addr(this,'','address','address');">
          </div>
          <div class="col-md-8 form-group mx-auto">
            <label for="address">Address</label>
            <input type="text" name="address" class="form-control" id="address" required>
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

        <div id="login" class="text-center nav-menu">
          <div class="book-a-table">
            <input type="submit" name="register" value="Register" class="btn">
          </div>
        </div>
      </form>

    </div>
  </div>
</section>

<?php

include('parts/footer.php');
