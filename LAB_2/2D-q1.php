<?php

require_once '2D-q1-config.php';

date_default_timezone_set(TIMEZONE);

logMessage("Dashboard loaded.");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo SITE_NAME; ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
  <h3>=== <?php echo SITE_NAME; ?> ===</h3>
  <p>Date: <?php echo date('d-m-Y'); ?></p>
  <p>Time: <?php echo date('H:i:s'); ?></p>
  <p>Day: <?php echo date('l'); ?></p>
  <p>Custom: <?php echo date("l, js F Y - h:i A"); ?></p>
  <p>Days remaining in <?php echo date('Y'); ?>: <?php echo 365 - (int) date('z'); ?></p>


  <?php
  include_once '2D-q1-footer.php';
  ?>
</body>
</html>