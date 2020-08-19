<?php

include('parts/header.php');

?>

  <section id="menu" class="menu section-bg" style="padding-top:150px">
    <div class="container" data-aos="fade-up" >

      <div class="section-title">
        <h2>Lineup</h2>
        <p>Check Our Authentic Coffee</p>
      </div>

      <?php
        $rowsForNew = $user->getItems('N');
        $rowsForExist = $user->getItems('E');
      ?>
      <?php if (empty($rowsForNew[0]) && empty($rowsForExist[0])): ?>
        <p class='text-center h4 my-3'>No items right now.</p>
      <?php else: ?>
        <main id="online" class='my-3' style="font-family: 'Playfair Display', serif;">

          <!-- show new arrivals -->
          <h2 class="text-center my-3">New Arrivals</h2>
          <div class='container row mx-auto'>
            <?php foreach ($rowsForNew as $row): ?>
              <div class='col-md-4 my-3'>
                <form action="userAction.php" method="post">
                  <table class='table'>
                    <tr style='background:#cda45e;'>
                      <th>Name</th>
                      <th><?= $row['item_name'] ?></th>
                    </tr>
                    <tr>
                      <td>Price</td>
                      <td><?= $row['item_price'] ?></td>
                    </tr>
                    <tr>
                      <td>Roast Level</td>
                      <td><?= $row['roast_level'] ?></td>
                    </tr>
                    <tr>
                      <td>Description</td>
                      <td><?= $row['item_desc'] ?></td>
                    </tr>
                    <tr>
                      <td colspan='2' class='text-center'>
                        <?= "<img src='assets/img/menu/" . $row['item_picture'] . "' alt='Item Photo' width='200px'>" ?>
                      </td>
                    </tr>
                    <tr>
                      <td colspan='2' class='text-center p-0' style='border-style:none;'>
                        <input type='hidden' name='loginID' value='<?= $loginID ?>'>
                      </td>
                    </tr>
                    <tr>
                      <td colspan='2' class='text-center p-0' style='border-style:none;'>
                        <input type='hidden' name='itemID' value='<?= $row['item_id'] ?>'>
                      </td>
                    </tr>
                    <tr>
                      <td colspan='2' class='text-center'>
                        <div id="login"class="text-center nav-menu my-3">
                          <input type='submit' name='putItem' value='Buy' class='btn' >
                        </div>
                      </td>
                    </tr>
                  </table>
                </form>
              </div>
            <?php endforeach ?>
          </div>

          <!-- show existing items -->
          <h2 class="text-center my-3">Existing Items</h2>
          <div class='container row mx-auto'>
            <?php foreach ($rowsForExist as $row): ?>
              <div class='col-md-4 my-3'>
                <form action="userAction.php" method="post">
                  <table class='table'>
                    <tr style='background:#cda45e;'>
                      <th>Name</th>
                      <th><?= $row['item_name'] ?></th>
                    </tr>
                    <tr>
                      <td>Price</td>
                      <td><?= $row['item_price'] ?></td>
                    </tr>
                    <tr>
                      <td>Roast Level</td>
                      <td><?= $row['roast_level'] ?></td>
                    </tr>
                    <tr>
                      <td>Description</td>
                      <td><?= $row['item_desc'] ?></td>
                    </tr>
                    <tr>
                      <td colspan='2' class='text-center'>
                        <?= "<img src='assets/img/menu/" . $row['item_picture'] . "' alt='Item Photo' width='200px'>" ?>
                      </td>
                    </tr>
                    <tr>
                      <td colspan='2' class='text-center p-0' style='border-style:none;'>
                        <input type='hidden' name='loginID' value='<?= $loginID ?>'>
                      </td>
                    </tr>
                    <tr >
                      <td colspan='2' class='text-center p-0' style='border-style:none;'>
                        <input type='hidden' name='itemID' value='<?= $row['item_id'] ?>'>
                      </td>
                    </tr>
                    <tr>
                      <td colspan='2' class='text-center'>
                        <div id="login"class="text-center nav-menu my-3">
                          <input type='submit' name='putItem' value='Buy' class='btn' >
                        </div>
                      </td>
                    </tr>
                  </table>
                </form>
              </div>
            <?php endforeach ?>
          </div>
          
        </main>
      <?php endif ?>


      
    </div>
  </section>

  
<?php

include('parts/footer.php');
