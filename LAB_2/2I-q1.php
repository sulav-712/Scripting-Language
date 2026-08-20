<?php

require_once 'value.php';

$conn = new mysqli("localhost", "root", "12345678", "lab_mysql");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$countQuery = "SELECT COUNT(*) AS total FROM students";
$countResult = $conn->query($countQuery);

if (!$countResult) {
    die("Count query failed: " . $conn->error);
}

$countRow = $countResult->fetch_assoc();

if ($countRow['total'] == 0) {

    $insertSQL = "INSERT INTO students (name, age, major) VALUES
        ('Ram', 20, 'CS'),
        ('Sita', 22, 'CS'),
        ('Hari', 25, 'IT'),
        ('Gita', 19, 'IT'),
        ('Nabin', " . ($D + 20) . ", 'CS')";

    if (!$conn->query($insertSQL)) {
        die("Insert failed: " . $conn->error);
    }
}

$totalSQL = "SELECT COUNT(*) AS total FROM students";
$totalResult = $conn->query($totalSQL);

if (!$totalResult) {
    die("Total query failed: " . $conn->error);
}

$totalRow = $totalResult->fetch_assoc();
$totalStudents = $totalRow['total'];

$avgSQL = "SELECT AVG(age) AS avg_age FROM students";
$avgResult = $conn->query($avgSQL);

if (!$avgResult) {
    die("Average query failed: " . $conn->error);
}

$avgRow = $avgResult->fetch_assoc();

$minSQL = "SELECT MIN(age) AS min_age FROM students";
$minResult = $conn->query($minSQL);

if (!$minResult) {
    die("Minimum query failed: " . $conn->error);
}

$minRow = $minResult->fetch_assoc();
$minAge = $minRow['min_age'];

$youngestSQL = "SELECT name FROM students WHERE age = $minAge LIMIT 1";
$youngestResult = $conn->query($youngestSQL);

$youngestRow = $youngestResult->fetch_assoc();
$youngestName = $youngestRow['name'];

$maxSQL = "SELECT MAX(age) AS max_age FROM students";
$maxResult = $conn->query($maxSQL);

if (!$maxResult) {
    die("Maximum query failed: " . $conn->error);
}

$maxRow = $maxResult->fetch_assoc();
$maxAge = $maxRow['max_age'];

$oldestSQL = "SELECT name FROM students WHERE age = $maxAge LIMIT 1";
$oldestResult = $conn->query($oldestSQL);

$oldestRow = $oldestResult->fetch_assoc();
$oldestName = $oldestRow['name'];

$majorSQL = "
    SELECT major, COUNT(*) AS cnt, AVG(age) AS avg_age
    FROM students
    GROUP BY major
";

$majorResult = $conn->query($majorSQL);

if (!$majorResult) {
    die("Major query failed: " . $conn->error);
}

$threshold = $A % 2 + 1;

$havingSQL = "
    SELECT major, COUNT(*) AS cnt
    FROM students
    GROUP BY major
    HAVING cnt > $threshold
";

$havingResult = $conn->query($havingSQL);

if (!$havingResult) {
    die("HAVING query failed: " . $conn->error);
}

$studentsSQL = "
    SELECT name, age, major
    FROM students
    ORDER BY age DESC
";

$studentsResult = $conn->query($studentsSQL);

if (!$studentsResult) {
    die("Students query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Student<?php echo $A; ?>'s Dashboard</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }

        .dashboard {
            max-width: 800px;
            margin: auto;
        }

        .box {
            border: 1px solid #333;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        h2 {
            margin-top: 25px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>

<div class="dashboard">

<div class="box">

<h1>
    =================================<br>
    Student<?php echo $A; ?>'s Dashboard<br>
    =================================
</h1>
<h2>1. Total Students: <?php echo $totalStudents; ?></h2>

<h2>2. Age Statistics:</h2>
<p>
    Average Age:
    <?php echo number_format($avgRow['avg_age'], 2); ?>
</p>

<p>
    Youngest:
    <?php echo $minAge; ?>
    (<?php echo htmlspecialchars($youngestName); ?>)
</p>

<p>
    Oldest:
    <?php echo $maxAge; ?>
    (<?php echo htmlspecialchars($oldestName); ?>)
</p>

<h2>3. Students per Major:</h2>

<?php

while ($row = $majorResult->fetch_assoc()) {

    echo htmlspecialchars($row['major']);
    echo ": ";
    echo $row['cnt'];
    echo " student(s) — Average Age: ";
    echo number_format($row['avg_age'], 2);
    echo "<br>";
}

?>

<h2>
    4. Majors with more than
    <?php echo $threshold; ?>
    student(s):
</h2>

<?php

if ($havingResult->num_rows == 0) {

    echo "No majors found.";

} else {

    while ($row = $havingResult->fetch_assoc()) {

        echo htmlspecialchars($row['major']);
        echo " (";
        echo $row['cnt'];
        echo ")<br>";
    }
}

?>

<h2>5. All students ordered by age (descending):</h2>

<table>
    <tr>
        <th>Name</th>
        <th>Age</th>
        <th>Major</th>
    </tr>

<?php

while ($row = $studentsResult->fetch_assoc()) {

    echo "<tr>";

    echo "<td>";
    echo htmlspecialchars($row['name']);
    echo "</td>";

    echo "<td>";
    echo $row['age'];
    echo "</td>";

    echo "<td>";
    echo htmlspecialchars($row['major']);
    echo "</td>";

    echo "</tr>";
}
?>
</table>
</div>
</div>
</body>
</html>

<?php

$conn->close();

?>