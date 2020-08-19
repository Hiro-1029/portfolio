<?php

include('parts/header.php');

$rowsToShowCartItems = $user->getCartItems($loginID, 'I');

$totalPrice = 0;

?>

  <main id="main">

    <section id="menu cart" class="menu section-bg" style="padding-top:150px;">
      <div class="container" data-aos="fade-up" >

        <div class="section-title pb-2">
          <p class="text-center">Your Cart</p>
        </div>
        
        <section class='my-3 py-0 text-dark rounded' style="font-family: 'Playfair Display', serif;background:white;">
          <!-- show message -->
          <?php if (!empty($message)): ?>
            <?= "<p class='pt-4 $color text-center' style='font-size: 20px;'>$message</p>" ?>
          <?php endif ?>

          <!-- show items in cart -->
          <?php if (empty($rowsToShowCartItems[0])): ?>
            <div class="text-center" style="font-family:sans-serif;">
              <p class='h5 m-2 p-2'>You cart is empty.</p>
              <p class='h5 m-2 p-2'>Please put some items at Online Shopping Page.</p>
              <div id="login" class="text-center nav-menu my-3">
                <a href="onlineShopping.php" class="w-25 m-3 mx-auto" style="background:#cda45e;">Go to Our lineup</a>
              </div>
              <p class='text-center h3 my-2 py-2'></p>
            </div>
          <?php else: ?>
            <div class='container row mx-auto'>
              <?php foreach ($rowsToShowCartItems as $row): ?>
                <?php $totalPrice += $row['item_price'] * $row['calc_quan'] ?>
                <div class='col-md-4 my-3 py-3'>
                  <form action="userAction.php" method="post">
                    <table class='table'>
                      <tr style='background:#cda45e;'>
                        <th>Name</th>
                        <th><?= $row['item_name'] ?></th>
                        </tr>
                      <tr>
                        <td>Price</td>
                        <td><span class='small'>USD </span><?php printf('%.2f', $row['item_price']) ?></td>
                      </tr>
                      <tr>
                        <td>Quantity</td>
                        <td><?= "<input type='number' min='1' name='calcQuan' value='" . $row['calc_quan'] . "' style='width:30%;'>" ?> 00g</td>
                      </tr>
                      <tr>
                        <td>Roast Level</td>
                        <td><?= $row['roast_level'] ?></td>
                      </tr>
                      <tr>
                        <td>Grind</td>
                        <td>
                          <?php if ($row['grind'] == 'D'): ?>
                            <select name="grind">
                              <option value="D" selected>Drip Grind</option>
                              <option value="W">Whole Bean</option>
                            </select>
                          <?php else: ?>
                            <select name="grind">
                              <option value="D">Drip Grind</option>
                              <option value="W" selected>Whole Bean</option>
                            </select>
                          <?php endif ?>
                        </td>
                      </tr>
                      <tr>
                        <td colspan='2' class='text-center'>
                          <?= "<img src='assets/img/menu/" . $row['item_picture'] . "' alt='Item Photo' width='200px'>" ?>
                        </td>
                      </tr>
                      <tr>
                        <td colspan='2' class='p-0' style='border-style:none;'>
                          <input type='hidden' name='calcID' value='<?= $row['calc_id'] ?>'>
                          <input type='hidden' name='loginID' value='<?= $loginID ?>'>
                          <input type='hidden' name='itemID' value='<?= $row['item_id'] ?>'>
                          <input type='hidden' name='calcStatus' value='<?= $row['calc_status'] ?>'>
                        </td>
                      </tr>
                      <tr>
                        <td colspan='2' class='text-center'>
                          <div id="login"class="text-center nav-menu my-3">
                            <input type='submit' name='updateCalc' value='Change' class='btn text-dark'>
                            <input type='submit' name='deleteItem' value='Delete' class='btn text-dark'>
                          </div>
                        </td>
                      </tr>
                    </table>
                  </form>
                </div>
              <?php endforeach ?>
            </div>

            <!-- calculate total payment -->
            <?php
              $handling = 2.00;
              $beforeTax = $totalPrice + $handling;
              $tax = $beforeTax * 0.072;
              $totalPay = $beforeTax + $tax;
              ?>

            <!-- show total payment -->
            <div class="container mx-auto p-5 border-top" style="font-family:sans-serif;">
              <p class="h3 mb-3 text-center">Order Summary</p>
              <table id="payment" class="mx-auto h5">
                <tr>
                  <td>Items: </td>
                  <td><span class="small">USD </span><?php printf('%.2f', $totalPrice) ?></td>
                </tr>
                <tr>
                  <td style="width:250px;">Shipping &amp; handling: </td>
                  <td><span class="small">USD </span><?php printf('%.2f', $handling) ?></td>
                </tr>
                <tr>
                  <td>Total before tax: </td>
                  <td><span class="small">USD </span><?php printf('%.2f', $beforeTax) ?></td>
                </tr>
                <tr>
                  <td>Consumption tax: </td>
                  <td><span class="small">USD </span><?= round($tax, 2) ?></td>
                </tr>
                <tr class="border-top border-success">
                  <td>Payment Total: </td>
                  <td class="h4"><span class="small">USD </span><?= round($totalPay, 2) ?></td>
                </tr>
              </table>

              <form action="userAction.php" method="post">
                <input type='hidden' name='loginID' value='<?= $loginID ?>'>
                <input type='hidden' name='totalPay' value='<?= round($totalPay, 2) ?>'>
                <?php foreach ($rowsToShowCartItems as $row): ?>
                  <input type="hidden" name="calcIDs[]" value="<?= $row['calc_id'] ?>">
                <?php endforeach ?>
                <div id="login"class="text-center nav-menu my-4">
                  <input type='submit' name='order' value='Order' class='btn w-25' style="background:#cda45e;">
                </div>
              </form>

            </div>
          <?php endif ?>

        </section>

      </div>
    </section>

  </main>

  
<?php

include('parts/footer.php');
