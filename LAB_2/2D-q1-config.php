<?php

require_once 'value.php';


define('SITE_NAME', "Lab 2D-q1 - Student" . $A);
define('TIMEZONE', "Asia/Kathmandu");
define('LOG_FILE', "2D-q1-" . $A . "-log.txt");

function logMessage($message) {
  $timestamp = date('Y-m-d H:i:s');
  $logEntry = "[$timestamp] - $message\n";
  file_put_contents(LOG_FILE, $logEntry, FILE_APPEND | LOCK_EX);
}

?>