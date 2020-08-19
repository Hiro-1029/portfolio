<?php

include('parts/header.php');

$rowsToShowCartItems = $user->getCartItems($loginID, 'I');

if (isset($_POST['detailHistory'])) { 
  $tranID = $_POST['tranID'];
  
  $rowToShowTran = $user->getTran($tranID);
  $rowsToShowHistoryDetail = $user->getTranDetails($tranID);

} elseif (isset($_POST['cancel'])) { 
  $tranID = $_POST['tranID'];

  $user->cancel($tranID);
}

?>

  <main id="main">

    <section id="menu cart" class="menu section-bg" style="padding-top:150px;">
      <div class="container" data-aos="fade-up">

        <div class="section-title pb-2">
          <p class="text-center">Your Order Detail</p>
        </div>

        
        <section class='my-3 py-0 text-dark rounded' style="font-family: 'Playfair Display', serif;background:white;">

          <!-- transaction summary -->
          <div class="card">
            <div class="card-header">
              <div class="d-flex mb-3">
                <p class="mr-5">Tran ID : <?= $rowToShowTran['tran_id'] ?></p>
                <p class="mr-5">Toral Pay : <span class='small'>USD </span><?php printf('%.2f', $rowToShowTran['total_pay']) ?></p>
                <p class="mr-5">Order Date : <?= substr($rowToShowTran['tran_date'], 0, 10) ?></p>
                <p>Address : <?= $result['address'] ?></p>
              </div>

              <div class="d-flex">
                <?php if ($rowToShowTran['tran_status'] == 'S'): ?>
                  <p class="mr-5">Status : Shipped</p>
                  <p class="mr-5">Shipped Date : <?= substr($rowToShowTran['shipped_date'], 0, 10) ?></p>
                <?php elseif ($rowToShowTran['tran_status'] == 'I'): ?>
                  <p class="mr-5">Status : In Process</p>
                <?php endif ?>
              </div>
              
            </div>

            <!-- transaction detail -->
            <div class="card-body">
              <div class='container row mx-auto'>
                <?php foreach ($rowsToShowHistoryDetail as $row): ?>
                  <div class='col-md-4 my-3 py-3'>
                    <form action="userAction.php" method="post">
                      <table class='table'>
                        <tr style='background:#cda45e;'>
                          <th>Item Name</th>
                          <th><?= $row['item_name'] ?></th>
                        </tr>
                        <tr>
                          <td>Price</td>
                          <td><span class='small'>USD </span><?php printf('%.2f', $row['item_price']) ?></td>
                        </tr>
                        <tr>
                          <td>Quantity</td>
                          <td><?= $row['calc_quan'] ?></td>
                        </tr>
                        <tr>
                          <td>Roast Level</td>
                          <td><?= $row['roast_level'] ?></td>
                        </tr>
                        <tr>
                          <td>Grind</td>
                          <td>
                            <?php if ($row['grind'] == 'D'): ?>
                              Drip Grind
                            <?php else: ?>
                              Whole Bean
                            <?php endif ?>
                          </td>
                        </tr>
                      </table>
                    </form>
                  </div>
                <?php endforeach ?>
              </div>
            </div>
          </div>
        </section>
      </div>
    </section>

  </main>

  
<?php

include('parts/footer.php');
