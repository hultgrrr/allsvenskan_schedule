<?php
  require_once('connect.php');
  header('Content-Type: text/html; charset=utf-8');

  // Correct encoding
  $query = "SET NAMES utf8";
  $conn->query($query);

  // Query
  $sql = 'SELECT * FROM '. $database_table;

  if (!$result = $conn->query($sql)) {
    die('Therewas an error while running the query [' . $conn->error . ']');
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SvFF Schedule Allsvenskan</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
      <h1>SvFF Schedule Allsvenskan</h1>
      <table id="schedule-table" class="table table-striped table-hover table-condensed tablesorter">
        <thead>
          <tr>
            <th>Omgång</th>
            <th>Datum</th>
            <th>Tid</th>
            <th>Veckodag</th>
            <th>Hemmalag</th>
            <th>Bortalag</th>
            <th>Arena</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $row['round_number'] ?></td>
            <td><?= $row['date'] ?></td>
            <td><?= substr($row['time'], 0, -3) ?></td>
            <td><?= $row['weekday'] ?></td>
            <td><?= $row['home_team'] ?></td>
            <td><?= $row['away_team'] ?></td>
            <td><?= $row['arena'] ?></td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.tablesorter.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>