<?php

require_once "value.php";

$conn = new mysqli("localhost", "root", "12345678", "lab_mysql");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$title = "2J-Q1 by " . $A . "." . $B;

$result = $conn->query("SELECT COUNT(*) AS total FROM students");

IF (!$result) {
  die("Error checking students table: " . $conn->error);
}

$row = $result->fetch_assoc();

if ((int)$row['total'] === 0) {
  $sql = "INSERT INTO students (name, age, major) VALUES
        ('Ram', " . ($A + 18) . ", 'Computer Science'),
        ('Sita', " . ($B + 19) . ", 'Information Systems'),
        ('Hari', " . ($C + 20) . ", 'Computer Science'),
        ('Gita', " . ($D + 21) . ", 'Data Science'),
        ('Nabin', " . ($A + $B + 18) . ", 'Computer Science')";

  if (!$conn->query($sql)) {
    die("Error inserting students: " . $conn->error);
  }
}

$sql = "CREATE TABLE IF NOT EXISTS popular_majors (
    major_name VARCHAR(50) PRIMARY KEY
)";

if (!$conn->query($sql)) {
    die("Error creating popular_majors: " . $conn->error);
}

$sql = "INSERT IGNORE INTO popular_majors (major_name) VALUES
    ('Computer Science'),
    ('Data Science')";

if (!$conn->query($sql)) {
    die("Error inserting popular majors: " . $conn->error);
}

$sql = "SELECT name, age, major
        FROM students
        WHERE age > (SELECT AVG(age) FROM students)";

$aboveAverage = $conn->query($sql);

if (!$aboveAverage) {
    die("Error in above-average query: " . $conn->error);
}

$avgResult = $conn->query("SELECT AVG(age) AS average_age FROM students");
$avgRow = $avgResult->fetch_assoc();
$averageAge = $avgRow['average_age'];

$sql = "SELECT name, major
        FROM students
        WHERE major IN (
            SELECT major_name
            FROM popular_majors
        )";

$popularStudents = $conn->query($sql);

if (!$popularStudents) {
    die("Error in popular majors query: " . $conn->error);
}

$sql = "SELECT name
        FROM students s
        WHERE NOT EXISTS (
            SELECT 1
            FROM scholarships sch
            WHERE sch.student_id = s.id
        )";

$withoutScholarships = $conn->query($sql);

if (!$withoutScholarships) {
    die("Error in NOT EXISTS query: " . $conn->error);
}

$scholarshipAmount = 5000 + ($A * 1000);


$check = $conn->query(
    "SELECT COUNT(*) AS total
     FROM scholarships
     WHERE student_id = 1"
);

$checkRow = $check->fetch_assoc();

if ((int)$checkRow['total'] === 0) {

    $sql = "INSERT INTO scholarships (student_id, amount)
            VALUES (1, $scholarshipAmount)";

    if (!$conn->query($sql)) {
        die("Error inserting scholarship: " . $conn->error);
    }
}

$sql = "SELECT s.name, sch.amount
        FROM students s
        JOIN scholarships sch ON s.id = sch.student_id";

$withScholarships = $conn->query($sql);

if (!$withScholarships) {
    die("Error in EXISTS query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($title) ?></title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            line-height: 1.7;
        }

        h1 {
            margin-bottom: 30px;
        }

        h2 {
            margin-bottom: 5px;
        }

        .section {
            margin-bottom: 35px;
        }
    </style>
</head>

<body>

<h1><?= htmlspecialchars($title) ?></h1>


<div class="section">
    <h2>=== Students Above Average Age ===</h2>

    Average age of all students:
    <?= number_format($averageAge, 1) ?>


    <?php while ($student = $aboveAverage->fetch_assoc()): ?>
        <div>
            <?= htmlspecialchars($student['name']) ?>
            — <?= htmlspecialchars($student['age']) ?>
            (<?= htmlspecialchars($student['major']) ?>)
        </div>
    <?php endwhile; ?>
</div>


<div class="section">
    <h2>=== Students in Popular Majors ===</h2>

    <?php while ($student = $popularStudents->fetch_assoc()): ?>
        <div>
            <?= htmlspecialchars($student['name']) ?>
            — <?= htmlspecialchars($student['major']) ?>
        </div>
    <?php endwhile; ?>
</div>

     ===================================== -->
<div class="section">
    <h2>=== Students Without Scholarships ===</h2>

    <?php while ($student = $withoutScholarships->fetch_assoc()): ?>
        <div>
            <?= htmlspecialchars($student['name']) ?>
        </div>
    <?php endwhile; ?>
</div>



<div class="section">
    <h2>=== Students With Scholarships ===</h2>

    <?php while ($student = $withScholarships->fetch_assoc()): ?>
        <div>
            <?= htmlspecialchars($student['name']) ?>
            — Amount: Rs. <?= htmlspecialchars($student['amount']) ?>
        </div>
    <?php endwhile; ?>
</div>

</body>
</html>

<?php
$conn->close();
?>