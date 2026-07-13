<?php
if($_SERVER["REQUEST_METHOD"] === "POST") {
  $username = htmlspecialchars($_POST["username"], ENT_QUOTES, 'UTF-8');
  echo "Welcome " . $username . "!";
}

