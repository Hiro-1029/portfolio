<?php

// show popular items in ranking.php
function showPop($top, $rows, $rowsNotSold, $status) {
  echo "<div id='best' class='container mb-5' style='margin-left: 100px;'>";
    if ($status == 'O') {
      echo "<h2 class='text-muted h3'>Orders top <span class='text-info'>" . $top . "</span></h2>";
    } elseif ($status == 'S') {
      echo "<h2 class='text-muted h3'>Sales top <span class='text-info'>" . $top . "</span></h2>";
    }
    echo "<table class='table table-striped table-hover'>";
      echo "<thead class='text-white' style='background:#cda45e;'>";
        echo "<tr>";
          echo "<th>Ranking</th>";
          if ($status == 'O') {
            echo "<th>Number of Sales</th>";
          } elseif ($status == 'S') {
            echo "<th>Sales Total</th>";
            echo "<th>Number of Sales</th>";
          }
          echo "<th>ID</th>";
          echo "<th>Name</th>";
          echo "<th>Price</th>";
          echo "<th>Stock</th>";
          echo "<th>Roast Level</th>";
        echo "</tr>";
      echo "</thead>";

      if (empty($rows[0])) {
        echo "<tr>";
          if ($status == 'O') {
            echo "<td colspan='7'>";
          } elseif ($status == 'S') {
            echo "<td colspan='8'>";
          }
            echo "<p class='text-center text-dark h4 my-3'>No data.</p>";
          echo "</td>";
        echo "</tr>";
      } elseif ($top <= count($rows)) {
        foreach ($rows as $key => $row) {
          $ranking = $key + 1;
          echo "<tr>";
            echo "<td class='align-middle'>" . $ranking . "</td>";
            if ($status == 'O') {
              echo "<td class='align-middle'>" . $row['Sum'] . "</td>";
            } elseif ($status == 'S') {
              echo "<td class='align-middle'>" . round($row['Sales'], 2) . "</td>";
              echo "<td class='align-middle'>" . $row['Sum'] . "</td>";
            }
            echo "<td class='align-middle'>" . $row['item_id'] . "</td>";
            echo "<td class='align-middle'>" . $row['item_name'] . "</td>";
            echo "<td class='align-middle'>USD " . $row['item_price'] . "</td>";
            echo "<td class='align-middle'>" . $row['item_quantity'] . "</td>";
            echo "<td class='align-middle'>" . $row['roast_level'] . "</td>";
          echo "</tr>";
        }
      } else {
        if ($top <= count($rows) + count($rowsNotSold)) {
          foreach ($rows as $key => $row) {
            $ranking = $key + 1;
            echo "<tr>";
              echo "<td class='align-middle'>" . $ranking . "</td>";
              if ($status == 'O') {
                echo "<td class='align-middle'>" . $row['Sum'] . "</td>";
              } elseif ($status == 'S') {
                echo "<td class='align-middle'>" . round($row['Sales'], 2) . "</td>";
                echo "<td class='align-middle'>" . $row['Sum'] . "</td>";
              }
              echo "<td class='align-middle'>" . $row['item_id'] . "</td>";
              echo "<td class='align-middle'>" . $row['item_name'] . "</td>";
              echo "<td class='align-middle'>USD " . $row['item_price'] . "</td>";
              echo "<td class='align-middle'>" . $row['item_quantity'] . "</td>";
              echo "<td class='align-middle'>" . $row['roast_level'] . "</td>";
            echo "</tr>";
          }
          $j = $top - count($rows);
          for ($i = 0; $i < $j; $i++) {
            $ranking++;
            echo "<tr>";
              echo "<td class='align-middle'>" . $ranking . "</td>";
              if ($status == 'O') {
                echo "<td class='align-middle'>" . 0 . "</td>";
              } elseif ($status == 'S') {
                echo "<td class='align-middle'>" . 0 . "</td>";
                echo "<td class='align-middle'>" . 0 . "</td>";
              }
              echo "<td class='align-middle'>" . $rowsNotSold[$i]['item_id'] . "</td>";
              echo "<td class='align-middle'>" . $rowsNotSold[$i]['item_name'] . "</td>";
              echo "<td class='align-middle'>USD " . $rowsNotSold[$i]['item_price'] . "</td>";
              echo "<td class='align-middle'>" . $rowsNotSold[$i]['item_quantity'] . "</td>";
              echo "<td class='align-middle'>" . $rowsNotSold[$i]['roast_level'] . "</td>";
            echo "</tr>";
          }
        } else {
          $top = count($rows) + count($rowsNotSold);
          echo "<tr><td colspan='7'><p class='h4 my-2 text-center'>Please input the number within <span class='text-danger'>" . $top . "</span>, because there are ". $top ." just types of items.</p></td></tr>";
        }
      }
    echo "</table>";
  echo "</div>";
}

// show unpopular items in ranking.php
function showUnpop($worst, $rows, $rowsNotSold, $status) {
  echo "<div class='container mb-5' style='margin-left: 100px;'>";
    if ($status == 'O') {
      echo "<h2 class='text-muted h3'>Orders worst <span class='text-info'>" . $worst . "</span></h2>";
    } elseif ($status == 'S') {
      echo "<h2 class='text-muted h3'>Sales worst <span class='text-info'>" . $worst . "</span></h2>";
    }
    echo "<table class='table table-striped table-hover'>";
      echo "<thead class='text-white' style='background:#cda45e;'>";
        echo "<tr>";
          echo "<th>Ranking</th>";
          if ($status == 'O') {
            echo "<th>Number of Sales</th>";
          } elseif ($status == 'S') {
            echo "<th>Sales Total</th>";
            echo "<th>Number of Sales</th>";
          }
          echo "<th>ID</th>";
          echo "<th>Name</th>";
          echo "<th>Price</th>";
          echo "<th>Stock</th>";
          echo "<th>Roast Level</th>";
        echo "</tr>";
      echo "</thead>";

      if (empty($rows[0]) && empty($rowsNotSold[0])) {
        echo "<tr>";
          if ($status == 'O') {
            echo "<td colspan='7'>";
          } elseif ($status == 'S') {
            echo "<td colspan='8'>";
          }
            echo "<p class='text-center text-dark h4 my-3'>No data.</p>";
          echo "</td>";
        echo "</tr>";
      } elseif ($worst <= count($rowsNotSold)) {
        for ($i = 0; $i < $worst; $i++) {
          $ranking = $i + 1;
          echo "<tr>";
            echo "<td class='align-middle'>" . $ranking . "</td>";
            if ($status == 'O') {
              echo "<td class='align-middle'>" . 0 . "</td>";
            } elseif ($status == 'S') {
              echo "<td class='align-middle'>" . 0 . "</td>";
              echo "<td class='align-middle'>" . 0 . "</td>";
            }
            echo "<td class='align-middle'>" . $rowsNotSold[$i]['item_id'] . "</td>";
            echo "<td class='align-middle'>" . $rowsNotSold[$i]['item_name'] . "</td>";
            echo "<td class='align-middle'>USD " . $rowsNotSold[$i]['item_price'] . "</td>";
            echo "<td class='align-middle'>" . $rowsNotSold[$i]['item_quantity'] . "</td>";
            echo "<td class='align-middle'>" . $rowsNotSold[$i]['roast_level'] . "</td>";
          echo "</tr>";
        }
      } else {
        if ($worst <= count($rows) + count($rowsNotSold)) {
          foreach ($rowsNotSold as $key => $row) {
            $ranking = $key + 1;
            echo "<tr>";
              echo "<td class='align-middle'>" . $ranking . "</td>";
              if ($status == 'O') {
                echo "<td class='align-middle'>" . 0 . "</td>";
              } elseif ($status == 'S') {
                echo "<td class='align-middle'>" . 0 . "</td>";
                echo "<td class='align-middle'>" . 0 . "</td>";
              }
              echo "<td class='align-middle'>" . $row['item_id'] . "</td>";
              echo "<td class='align-middle'>" . $row['item_name'] . "</td>";
              echo "<td class='align-middle'>USD " . $row['item_price'] . "</td>";
              echo "<td class='align-middle'>" . $row['item_quantity'] . "</td>";
              echo "<td class='align-middle'>" . $row['roast_level'] . "</td>";
            echo "</tr>";
          }
          $j = $worst - count($rowsNotSold);
          for ($i = 0; $i < $j; $i++) {
            $ranking++;
            echo "<tr>";
              echo "<td class='align-middle'>" . $ranking . "</td>";
              if ($status == 'O') {
                echo "<td class='align-middle'>" . $rows[$i]['Sum'] . "</td>";
              } elseif ($status == 'S') {
                echo "<td class='align-middle'>" . round($rows[$i]['Sales'], 2) . "</td>";
                echo "<td class='align-middle'>" . $rows[$i]['Sum'] . "</td>";
              }
              echo "<td class='align-middle'>" . $rows[$i]['item_id'] . "</td>";
              echo "<td class='align-middle'>" . $rows[$i]['item_name'] . "</td>";
              echo "<td class='align-middle'>USD " . $rows[$i]['item_price'] . "</td>";
              echo "<td class='align-middle'>" . $rows[$i]['item_quantity'] . "</td>";
              echo "<td class='align-middle'>" . $rows[$i]['roast_level'] . "</td>";
            echo "</tr>";
          }
        } else {
          $worst = count($rows) + count($rowsNotSold);
          echo "<tr><td colspan='7'><p class='h4 my-2 text-center'>Please input the number within <span class='text-danger'>" . $worst . "</span>, because there are ". $worst ." just types of items.</p></td></tr>";
        }
      }
    echo "</table>";
  echo "</div>";
}
