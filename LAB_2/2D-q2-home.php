/* A small site needs a header, navigation, and footer shared across multiple pages using include/require. */

<?php
require_once '2D-q2-config.php';
include_once '2D-q2-header.php';
?>

<main>
  <h2>Welcome to <?php echo SITE_NAME; ?>!</h2>
  <p>Author: <?php echo AUTHOR; ?></p>
  <p>Year: <?php echo date('Y'); ?></p>
</main>

<?php
include_once '2D-q2-footer.php';
?>

/* Code from 2D-q2-about.php
<?php
require_once '2D-q2-config.php';
include_once '2D-q2-header.php';
?>

<main>
  <h2>About <?php echo SITE_NAME; ?></h2>
  <p>Created by: <?php echo AUTHOR; ?> for CACS252.</p>
  <p>Current date: <?php echo date('Y-m-d'); ?></p>
</main>

<?php
include_once '2D-q2-footer.php';
?> */

/* Code from 2D-q2-header.php
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
  </header> */ 

/* Code from 2D-q2-footer.php
<footer>
  &copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>
</footer>
</body>
</html> */ 

/* Code from 2D-q2-config.php
<?php
require_once 'value.php';

define('SITE_NAME', 'MyLab-' . $A . $B);
define('AUTHOR', 'Student' . $C);
?> */