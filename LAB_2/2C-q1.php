/* A website needs a user registration page. The user fills in their details and submits the form. The PHP script receives the data via POST and displays a welcome message. */

<?php
require_once 'value.php';

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
    echo "Course: $course \n";
  }
}
?>

/* Code from 2C-q1.html
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Form - Student8</title>
</head>
<body>
  <h1>Registration Form - Student8</h1>

  <form method="POST" action="2C-q1.php?ref=85">
    <label for="fullname">Full Name:</label>
    <input type="text" id="fullname" name="fullname" placeholder="Name (min 8 chars)" required> <br> <br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="age">Age:</label>
    <input type="number" id="age" name="age" required><br><br>

    <label for="course">Course: </label>
    <select id="course" name="course" required>
      <option value="">Select Course</option>
      <option value="BCA">BCA</option>
      <option value="BIT">BIT</option>
      <option value="BIM">BIM</option>
      <option value="BSc. CSIT">BSc. CSIT</option>
    </select><br><br>

    <input type="submit" name="Submit" value="Submit">
  </form>
</body>
</html> */