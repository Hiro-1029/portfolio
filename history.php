<?php

include('parts/header.php');

$rowsToShowCartItems = $user->getCartItems($loginID, 'I');
$rowsToShowHistory = $user->getTransForHistory($loginID);

?>

  <main id="main">

    <section id="menu cart" class="menu section-bg" style="padding-top:150px;">
      <div class="container" data-aos="fade-up" >

        <div class="section-title pb-2">
          <p class="text-center">Your Order History</p>
        </div>

        <section class='my-3 py-0 text-dark rounded' style="font-family: 'Playfair Display', serif;background:white;">

          <!-- show message -->
          <?php if (!empty($message)): ?>
            <?= "<p class='pt-4 $color text-center' style='font-size: 20px;'>$message</p>" ?>
          <?php endif ?>

          <!-- show items in cart -->
          <?php if (empty($rowsToShowHistory[0])): ?>
            <div class="text-center" style="font-family:sans-serif;">
              <p class='h5 m-2 p-2'>No Order History</p>
              <div id="login" class="text-center nav-menu my-3">
                <a href="onlineShopping.php" class="w-25 m-3 mx-auto" style="background:#cda45e;">Go to Our lineup</a>
              </div>
              <p class='text-center h3 my-2 py-2'></p>
            </div>
          <?php else: ?>
            <div class='container row mx-auto'>
              <?php foreach ($rowsToShowHistory as $row): ?>
                <div class='col-md-6 my-3 py-3'>
                  <form action="historyDetail.php" method="post">
                    <table class='table'>
                      <tr style='background:#cda45e;'>
                        <th>Transaction ID</th>
                        <th><?= $row['tran_id'] ?></th>
                      </tr>
                      <tr>
                        <td>Total Pay</td>
                        <td><span class='small'>USD </span><?php printf('%.2f', $row['total_pay']) ?></td>
                      </tr>
                      <tr>
                        <td>Order Date</td>
                        <td><?= substr($row['tran_date'], 0, 10) ?></td>
                      </tr>
                      <tr>
                        <td>Status</td>
                        <td>
                          <?php if ($row['tran_status'] == 'S'): ?>
                            <?= "Already Shipped" ?>
                          <?php elseif ($row['tran_status'] == 'I'): ?>
                            <?= "In Process" ?>
                          <?php elseif ($row['tran_status'] == 'R'): ?>
                            <?= "Canceled" ?>
                          <?php endif ?>
                        </td>
                      </tr>
                      <tr>
                        <td>Shipped Date</td>
                        <td><?= substr($row['shipped_date'], 0, 10) ?></td>
                      </tr>
                      <tr>
                        <td colspan='2' class='p-0' style='border-style:none;'>
                          <input type='hidden' name='tranID' value='<?= $row['tran_id'] ?>'>
                        </td>
                      </tr>
                      <tr>
                        <td colspan='2' class='text-center'>
                          <div id="login"class="text-center nav-menu my-3">
                            <input type='submit' name='detailHistory' value='Detail' class='btn text-dark'>
                            <?php if ($row['tran_status'] == 'I'): ?>
                              <input type='submit' name='cancel' value='Cancel' class='btn text-dark'>
                            <?php endif ?>
                          </div>
                        </td>
                      </tr>
                    </table>
                  </form>
                </div>
              <?php endforeach ?>
            </div>
          <?php endif ?>
        </section>
      </div>
    </section>

  </main>

  
<?php

include('parts/footer.php');
