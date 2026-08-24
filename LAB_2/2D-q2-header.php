<?php
require_once '2D-q2-config.php';
require_once 'value.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo SITE_NAME; ?></title>
</head>
<body>
  <header>
    <h1><?php echo SITE_NAME; ?></h1>

    <nav>
      <a href="2D-q2-home.php">Home (Page <?php echo $A; ?>)</a> |
      <a href="2D-q2-about.php">About (Page <?php echo $B; ?>)</a> |
    </nav>
  </header>