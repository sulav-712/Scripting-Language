<?php
$mysqli = new mysqli("localhost", "root", "12345678", "lab_mysql");

if ($mysqli->connect_error) {
  die ("Connection failed: " . $mysqli->connect_error);
}
else {
  echo "Connected successfully";
}
?>