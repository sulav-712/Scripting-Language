<?php
session_start();

date_default_timezone_set('Asia/Kathmandu');

require_once 'config.php';
include_once 'header.php';

if (!isset($_SESSION['visits'])) {
  $_SESSION['visits'] = 0;
}
$_SESSION['visits']++;

function logMessage(string $msg) : void {
  $line = '[' . date('Y-m-d H:i:s') . '] ' . $msg . PHP_EOL;
  file_put_contents('lab_log.txt', $line, FILE_APPEND);
}

echo "Date: " . date('Y-m-d') . "<br>";
echo "Time: " . date('H:i:s') . "<br>";
echo "Day: " . date('l') . "<br>";
echo "Year: " . date('Y') . "<br>";

echo "Visits: " . $_SESSION['visits'] . "<br>";

logMessage("Page loaded: Visit count: " . $_SESSION['visits']);


?>