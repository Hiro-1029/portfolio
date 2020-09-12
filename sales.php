<?php

require_once('classes/crud.php');

$loginID = $_SESSION['login_id'];
$now = time();
if ($now > $_SESSION['expire']) {
  unset($_SESSION['message']);
  unset($_SESSION['color']);
} else {
  $message = $_SESSION['message'];
  $color = $_SESSION['color'];
}

$user = new CRUD;
$result = $user->getUser($loginID);
  
$tranMonths = $user->getTranMonths('', 'A', 12);
$tranMonthsForStartAndEnd = $user->getTranMonths('', 'A', '');

// past months pay
$totalPays = [];
foreach ($tranMonths as $key => $month) {
  $totalPays[$month] = $user->getTotalPayByUserID('', $month);
}

if ($result['status'] == 'U' || $result['status'] == 'R' ||empty($loginID)) {
  header("location: logout.php");
  exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="Description" content="Enter your description here"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
<link rel="stylesheet" href="assets/css/style.css">
<title>Transaction Detail</title>
<style>
  body {
    background-color: white;
  }
  canvas {
    background: #eee;
    height: 400px !important;
    margin: 30px auto;
  }
  p {
    color: red !important;
  }
</style>
</head>
<body>

  <?php include('parts/navbar.php') ?>

  <main class="my-5" style="margin-top:75px !important;">

    <!-- form to select months -->
    <div class="container">
      <div id="month" class="input-group mb-3">
        <p class="text-muted h4 pr-3 mb-0 align-self-center">Past Sales Totals &rarr; </p>
        <form action="" method="post" class="form-inline">
          <select name="monthStart" class="custom-select form-inline" id="inputGroupSelect01" style="width:100px;">
            <?php foreach ($tranMonthsForStartAndEnd as $row): ?>
              <option value="<?= $row ?>"><?= $row ?></option>
            <?php endforeach ?>
          </select>
          <p class="text-muted h4 mb-0 mx-2">&#12316;</p>
          <select name="monthEnd" class="custom-select form-inline mr-2" id="inputGroupSelect01" style="width:100px;">
            <?php foreach ($tranMonthsForStartAndEnd as $row): ?>
              <option value="<?= $row ?>"><?= $row ?></option>
            <?php endforeach ?>
          </select>
          <button type="submit" name="monthForSales" class="btn form-control text-white ml-auto" style="background:#daa520; width:100px;">Search</button>
        </form>
      </div>
    </div>

    <!-- to show graph and chart during selected months -->
    <?php 
      if (isset($_POST['monthForSales'])) {
        $monthStart = $_POST['monthStart'];
        $monthEnd = $_POST['monthEnd'];
        
        if ($monthStart > $monthEnd) {
          $x = $monthStart;
          $monthStart = $monthEnd;
          $monthEnd = $x;
        }

        $tranMonthsSelected = $user->getTranMonthsSelected($monthStart, $monthEnd);

        $totalPaysSelected = [];
        foreach ($tranMonthsSelected as $key => $monthSelected) {
          $totalPaysSelected[$monthSelected] = $user->getTotalPayByUserID('', $monthSelected);
        }

        echo "<div class='container mt-5'>
                <h2 class='text-muted h3 mr-auto'>Total Sales Graph from " . $monthStart . " to " . $monthEnd . "</h2>
                <canvas id='myBarChartSelected' width='600px' height='240'>
                  Canvas Not supported...
                </canvas>
              </div>";

          echo "<div class='container mt-5'>";
            echo "<h2 class='text-muted h3 mr-auto'>Total Sales from " . $monthStart . " to " . $monthEnd . "</h2>";
    
            echo "<table class='table table-striped table-hover w-50 mr-auto'>
                    <thead style='background:#daa520;'>
                      <tr>
                        <th>Month</th>
                        <th>Total Sales</th>
                      </tr>
                    </thead>";
              echo "<tbody>";
                $totalPayment = 0;
                foreach ($totalPaysSelected as $monthSelected => $pay) {
                  echo "<tr>";
                    echo "<td>" . $monthSelected . "</td>";
                    echo "<td>";
                      echo round($pay['Sum'], 2);
                      $totalPayment += round($pay['Sum'], 2);
                    echo "</td>";
                  echo "</tr>";
                }
                echo "<tr class='text-success'>";
                  echo "<td>Total</td>";
                  echo "<td>" . $totalPayment . "</td>";
                echo "</tr>";
              echo "</tbody>";
            echo "</table>";
          echo "</div>";
      }
    ?>
  

    <!-- show graph during recent 12 months -->
    <div class="container mt-5">
      <h2 class="text-muted h3 mr-auto">Total Sales Graph during 12 Months</h2>
      <canvas id="myBarChart" width="600px" height="240">
        Canvas Not supported...
      </canvas>
    </div>

    <!-- show total pay during recent 12 months -->
    <div class="container mt-5">
      <h2 class="text-muted h3 mr-auto">Total Sales in Each Month</h2>

      <table class="table table-striped table-hover w-50 mr-auto">
        <thead style="background:#daa520;">
          <tr>
            <th>Month</th>
            <th>Total Sales</th>
          </tr>
        </thead>

        <tbody>
          <?php $totalPayment = 0 ?>
          <?php foreach ($totalPays as $month => $pay): ?>
            <tr>
              <td><?= $month ?></td>
              <td>
                <?php
                  echo round($pay['Sum'], 2);
                  $totalPayment += round($pay['Sum'], 2);
                ?>
              </td>
            </tr>
          <?php endforeach ?>
          <!-- total payment -->
          <tr class="text-success">
              <td>Total</td>
              <td><?= $totalPayment ?></td>
            </tr>
        </tbody>
      </table>
    </div>

  </main>

  

<!-- JS scripts for graph -->
<script>
  let graphDatas = JSON.parse('<?= json_encode($totalPays) ?>');
</script>
<script>
  let graphDatasSelected = JSON.parse('<?= json_encode($totalPaysSelected) ?>');
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script src="assets/js/canvas.js"></script>

<!-- bootstrap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>