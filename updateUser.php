<?php

include('parts/headerForUser.php');

if ($result['status'] == 'A' || $result['status'] == 'S' || empty($loginID)) {
  header('Location: login.php');
} 

?>


<section id="hero" class="hero" style="padding-top:30px;">

  <div class="container" data-aos="fade-up">
    <div class="section-title text-center">
      <p>Your Profile</p>
    </div>

    <div class="w-50 mx-auto my-2 mt-lg-0">

      <form action="userAction.php" method="post" class="text-center mx-auto">
        <table width="100%">
          <tr>
            <td>Username</td>
            <td>
              <input type="text" name="username" value="<?= $result['username'] ?>" class="form-control w-100">
            </td>
          </tr>
          <tr>
            <td>First Name</td>
            <td>
              <input type="text" name="firstName" value="<?= $result['first_name'] ?>" class="form-control w-100">
            </td>
          </tr>
          <tr>
            <td>Last Name</td>
            <td>
              <input type="text" name="lastName" value="<?= $result['last_name'] ?>" class="form-control w-100">
            </td>
          </tr>
          <tr>
            <td>Birthday</td>
            <td>
              <input type="date" name="bday" value="<?= $result['bday'] ?>" class="form-control w-100">
            </td>
          </tr>
          <tr>
            <td>Address</td>
            <td>
              <input type="text" name="address" value="<?= $result['address'] ?>" class="form-control w-100">
            </td>
          </tr>
          <tr>
          <tr>
            <td>Email</td>
            <td>
              <input type="email" name="email" value="<?= $result['email'] ?>" class="form-control w-100">
            </td>
          </tr>
          <tr>
            <td>
              <input type="hidden" name="loginID" value="<?= $result['login_id'] ?>">
            </td>
            <td>
              <input type="hidden" name="status" value="<?= $result['status'] ?>">
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <?php if (empty($messages[0])): ?>
                <p class="pt-3 text-warning">
                  If you'd like to change your profile information, <br>please change your datas above and press the button below.
                </p>
              <?php else: ?>
                <?= "<p class='pt-3 $color'>" ?>
                  <?php foreach ($messages as $message): ?>
                    <?= $message . "<br>" ?>
                  <?php endforeach ?>
                </p>
              <?php endif ?>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <input type="submit" name="updateUser" value="Update Profile" class="btn rounded-pill text-white w-50 mt-2" style="background:#cda45e;">
            </td>
          </tr>
        </table>
      </form>

    </div>
  </div>
</section>

<?php

include('parts/footer.php');
