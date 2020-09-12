<?php

// show inventory in inventory.php
function inventory($stock, $rows) {
  echo "<div class='container mb-5'>";
    echo "<h2 class='text-muted h3'>Items which stock is less than <span class='text-success'>" . $stock . "</span></h2>";
    echo "<table class='table table-striped table-hover'>";
      echo "<thead class='text-white' style='background:#cda45e;'>";
        echo "<tr>";
          echo "<th>Item ID</th>";
          echo "<th>Item Name</th>";
          echo "<th>Item Price</th>";
          echo "<th>Item Quantity</th>";
          echo "<th>Roast Level</th>";
          echo "<th></th>";
        echo "</tr>";
      echo "</thead>";

      if (empty($rows[0])) {
        echo "<tr>";
          echo "<td colspan='6'>";
            echo "<p class='text-center text-dark h4 my-3'>No data.</p>";
          echo "</td>";
        echo "</tr>";
      } else {
        foreach ($rows as $row) {
          echo "<tr>";
            echo "<td class='align-middle'>" . $row['item_id'] . "</td>";
            echo "<td class='align-middle'>" . $row['item_name'] . "</td>";
            echo "<td class='align-middle'>USD " . $row['item_price'] . "</td>";
            if ($row['item_quantity'] <= 5) {
              echo "<td class='align-middle table-danger h5'>" . $row['item_quantity'] . "</td>";
            } elseif ($row['item_quantity'] <= 10) {
              echo "<td class='align-middle table-warning h5'>" . $row['item_quantity'] . "</td>";
            } else {
              echo "<td class='align-middle h5'>" . $row['item_quantity'] . "</td>";
            }
            echo "<td class='align-middle'>" . $row['roast_level'] . "</td>";
            echo "<td>";
              echo "<form action='userAction.php' method='post'>";
                echo "<input type='hidden' name='itemID' value='" . $row['item_id'] . "'>";
                echo "<button type='submit' name='getItem' class='btn form-control text-white' style='background:#cda45e;'>Change</button>";

              echo "</form>";
            echo "</td>";
          echo "</tr>";
        }
      }
    echo "</table>";
  echo "</div>";
}
