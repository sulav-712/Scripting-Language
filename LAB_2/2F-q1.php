/* A website tracks how many times a user has visited different pages during their session using PHP sessions. */

<?php
require_once 'value.php';

session_start();

if (isset($_GET['reset']) && $_GET['reset'] == '1') {
  session_destroy();
  session_start();
  header("Location: 2F-q1.php");
  exit;
}

if (!isset($_SESSION['username'])) {
  $_SESSION['username'] = "Student" . $A;
}

if (!isset($_SESSION['page_views'])) {
  $_SESSION['page_views'] = [];
}

if (!isset($_SESSION['page_views']['home'])) {
  $_SESSION['page_views']['home'] = 0;
}
$_SESSION['page_views']['home']++;

$visitCount = $_SESSION['page_views']['home'];
$username = $_SESSION['username'];
$sessionId = session_id();
$showSessionId = ($D % 2 === 0);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>2F-Q1 by <?php echo "Student" . $A . $B; ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; white-space: pre-line; }
        .box { border: 1px solid #ccc; padding: 10px; display: inline-block; }
    </style>
</head>
<body>
<div class="box">
==============================
   Session Visit Tracker
==============================
<?php if ($showSessionId): ?>
Session ID: <?php echo htmlspecialchars($sessionId) . "\n"; ?>
<?php endif; ?>
You have visited this page <?php echo $visitCount; ?> times.
==============================
</div>

<p>Welcome back, <?php echo htmlspecialchars($username); ?>!</p>

<p><a href="2F-q1.php?reset=1">Reset Session</a></p>
</body>
</html>