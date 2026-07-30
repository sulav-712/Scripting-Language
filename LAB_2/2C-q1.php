<?php

$A = 8;
$B = 5;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $fullname = $_POST['fullname'] ?? '';
  $email = $_POST['email'] ?? '';
  $age = $_POST['age'] ?? '';
  $course = $_POST['course'] ?? '';

  $fullname = htmlspecialchars($fullname, ENT_QUOTES, 'UTF-8');
  $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
  $course = htmlspecialchars($course, ENT_QUOTES, 'UTF-8');


  $age = (int) $age;

  if ($age < 18) {
    echo "Age must be above 18.";
  } else {
    echo "Name: $fullname \n";
    echo "Email: $email \n";
    echo "Age: $age \n";
    echo "Course: $course \n>";
  }
  
}
?>