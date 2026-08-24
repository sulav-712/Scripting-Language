/* A data analyst needs to find students who are above average age, and students who belong to specific majors using subqueries. */

<?php
require_once "value.php";
$conn = new mysqli("localhost", "root", "12345678", "lab_mysql");
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);

$title = "2J-Q1 by $A.$B";
$result = $conn->query("SELECT COUNT(*) AS total FROM students");
if (!$result)
    die("Error checking students table: " . $conn->error);

if ((int)$result->fetch_assoc()['total'] === 0) {
    $sql = "INSERT INTO students (name, age, major) VALUES
        ('Ram'," . ($A + 18) . ",'Computer Science'),
        ('Sita'," . ($B + 19) . ",'Information Systems'),
        ('Hari'," . ($C + 20) . ",'Computer Science'),
        ('Gita'," . ($D + 21) . ",'Data Science'),
        ('Nabin'," . ($A + $B + 18) . ",'Computer Science')";

    if (!$conn->query($sql))
        die("Error inserting students: " . $conn->error);
}

$sql = "CREATE TABLE IF NOT EXISTS popular_majors (
    major_name VARCHAR(50) PRIMARY KEY
)";

if (!$conn->query($sql))
    die("Error creating popular_majors: " . $conn->error);

$sql = "INSERT IGNORE INTO popular_majors (major_name) VALUES
    ('Computer Science'),('Data Science')";

if (!$conn->query($sql))
    die("Error inserting popular majors: " . $conn->error);

$aboveAverage = $conn->query("
    SELECT name, age, major
    FROM students
    WHERE age > (SELECT AVG(age) FROM students)
");
if (!$aboveAverage)
    die("Error in above-average query: " . $conn->error);

$result = $conn->query("SELECT AVG(age) AS average_age FROM students");
$averageAge = $result->fetch_assoc()['average_age'];

$popularStudents = $conn->query("
    SELECT name, major
    FROM students
    WHERE major IN (SELECT major_name FROM popular_majors)
");
if (!$popularStudents)
    die("Error in popular majors query: " . $conn->error);

$withoutScholarships = $conn->query("
    SELECT name
    FROM students s
    WHERE NOT EXISTS (
        SELECT 1 FROM scholarships sch
        WHERE sch.student_id = s.id
    )
");
if (!$withoutScholarships)
    die("Error in NOT EXISTS query: " . $conn->error);

$scholarshipAmount = 5000 + $A * 1000;
$check = $conn->query("SELECT COUNT(*) AS total FROM scholarships WHERE student_id = 1");

if ((int)$check->fetch_assoc()['total'] === 0) {
    $sql = "INSERT INTO scholarships (student_id, amount)
            VALUES (1, $scholarshipAmount)";

    if (!$conn->query($sql))
        die("Error inserting scholarship: " . $conn->error);
}

$withScholarships = $conn->query("
    SELECT s.name, sch.amount
    FROM students s
    JOIN scholarships sch ON s.id = sch.student_id
");
if (!$withScholarships)
    die("Error in EXISTS query: " . $conn->error);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <style>
        body { font-family:Arial,sans-serif; margin:40px; }
        .section { margin-bottom:30px; }
    </style>
</head>
<body>

<h1><?= htmlspecialchars($title) ?></h1>

<div class="section">
    <h2>=== Students Above Average Age ===</h2>
    Average age of all students: <?= number_format($averageAge, 1) ?>

    <?php while ($student = $aboveAverage->fetch_assoc()): ?>
        <div>
            <?= htmlspecialchars($student['name']) ?> —
            <?= htmlspecialchars($student['age']) ?>
            (<?= htmlspecialchars($student['major']) ?>)
        </div>
    <?php endwhile; ?>
</div>

<div class="section">
    <h2>=== Students in Popular Majors ===</h2>

    <?php while ($student = $popularStudents->fetch_assoc()): ?>
        <div>
            <?= htmlspecialchars($student['name']) ?> —
            <?= htmlspecialchars($student['major']) ?>
        </div>
    <?php endwhile; ?>
</div>

<div class="section">
    <h2>=== Students Without Scholarships ===</h2>

    <?php while ($student = $withoutScholarships->fetch_assoc()): ?>
        <div><?= htmlspecialchars($student['name']) ?></div>
    <?php endwhile; ?>
</div>

<div class="section">
    <h2>=== Students With Scholarships ===</h2>

    <?php while ($student = $withScholarships->fetch_assoc()): ?>
        <div>
            <?= htmlspecialchars($student['name']) ?> —
            Amount: Rs. <?= htmlspecialchars($student['amount']) ?>
        </div>
    <?php endwhile; ?>
</div>
<?php $conn->close(); ?>
</body>
</html>