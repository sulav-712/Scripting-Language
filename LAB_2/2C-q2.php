<?php

require_once 'value.php';


$pageTitle = "Profile Viewer - " . ($A + $B) . "_" . $C;

$hidddenId = "STU-" . $A . $B . $C;

$name = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : "Guest";
$age = isset($_GET['age']) ? htmlspecialchars($_GET['age']) : "Unknown";
$city = isset($_GET['city']) ? htmlspecialchars($_GET['city']) : "Unknown";
$id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : "N/A";

$hasParams = !empty($_GET);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $pageTitle; ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
  <?php if (!$hasParams): ?>
    <h2>Enter Profile Information</h2>
    <form method="GET" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
      <label>Name: <input type="text" name="name" value="Guest"></label><br><br>
      <label>Age: <input type="number" name="age" value="Unknown"></label><br><br>
      <label>City: <input type="text" name="city" value="Unknown"></label><br><br>
      <input type="hidden" name="id" value="<?php echo $hidddenId; ?>"><br><br>
      <button type="submit">View Profile</button>
    </form>


    <?php else: ?>
      <pre>
===================================
          STUDENT PROFILE
===================================
ID: <?php echo $id; ?>
Name: <?php echo $name; ?>
Age: <?php echo $age; ?>
City: <?php echo $city; ?>
      </pre>
    <?php endif; ?>
</body>
</html>
      