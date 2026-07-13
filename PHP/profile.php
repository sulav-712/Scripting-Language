<?php
$name = isset($_GET['name']) ? htmlspecialchars($_GET['name'], ENT_QUOTES, 'UTF-8') : 'Guest';
$age = isset($_GET['age']) ? htmlspecialchars($_GET['age'], ENT_QUOTES, 'UTF-8') : 'Unknown';

echo "Name: " . $name . "<br>";
echo "Age: " . $age . "<br>";
?>