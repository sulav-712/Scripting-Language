<?php

session_start();
require $_server['DOCUMENT_ROOT'] . '/program/db/db.php';

header("Content-Type: application/json");

if ($_server['REQUEST_METHOD'] === 'POST') {
  $user = trim($_POST['user']);
}

$stmt = $mysql->prepare("SELECT count(*) as total FROM users WHERE username = ?");
$stmt->execute([$user]);
$stmt->fetchAll();

if ($stmt->fetch()['total'] > 0) {
  echo json_encode([
    "check" => "Unavailable"
  ]);
  exit;
}


echo json_encode([
  "check" => "Available"
]);


?>