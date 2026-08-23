/* A school wants to see a combined view of students and their grades. The dashboard should demonstrate all three join types (INNER, LEFT, RIGHT) and explain the differences */

<?php
require_once 'value.php';
$conn = new mysqli("localhost", "root", "12345678", "lab_mysql");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
$title = "2K-Q1 Joins — " . $A . "v" . $B;
$cellPadding = $D + 2;

$sql = "INSERT IGNORE INTO students (id, name, age, major) VALUES
    (1, 'Student$A', 20, 'CS'),
    (2, 'Student$B', 22, 'IT'),
    (3, 'Student$C', 21, 'CS'),
    (4, 'Student$D', 23, 'DS')";

if (!$conn->query($sql)) {
    die("Error inserting students: " . $conn->error);
}
$sql = "INSERT IGNORE INTO grades (student_id, course, grade) VALUES
    (1, 'PHP', 'A'),
    (1, 'MySQL', 'B'),
    (2, 'PHP', 'B'),
    (5, 'DBMS', 'C')";

if (!$conn->query($sql)) {
    die("Error inserting grades: " . $conn->error);
}
$sql = "SELECT s.id, s.name, g.course, g.grade
        FROM students s
        INNER JOIN grades g ON s.id = g.student_id
        ORDER BY s.id";

$innerResult = $conn->query($sql);

if (!$innerResult) {
    die("Error in INNER JOIN: " . $conn->error);
}

$sql = "SELECT s.id, s.name, g.course, g.grade
        FROM students s
        LEFT JOIN grades g ON s.id = g.student_id
        ORDER BY s.id";

$leftResult = $conn->query($sql);

if (!$leftResult) {
    die("Error in LEFT JOIN: " . $conn->error);
}
$sql = "SELECT s.id, s.name, g.course, g.grade
        FROM students s
        RIGHT JOIN grades g ON s.id = g.student_id";

$rightResult = $conn->query($sql);

if (!$rightResult) {
    die("Error in RIGHT JOIN: " . $conn->error);
}

$innerRows = $innerResult->num_rows;
$leftRows = $leftResult->num_rows;
$rightRows = $rightResult->num_rows;
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
        }

        h1 {
            margin-bottom: 30px;
        }

        table {
            margin-bottom: 30px;
        }

        caption {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            text-align: left;
        }

        th, td {
            padding: 5px;
        }

        .no-grade {
            background-color: #f8d7da;
        }

        .orphan {
            background-color: #fff3cd;
        }

        .summary {
            margin-top: 30px;
        }
    </style>
</head>
<body>
<h1><?= htmlspecialchars($title) ?></h1>

<table border="1" cellpadding="<?= $cellPadding ?>">
    <caption>INNER JOIN — Only students WITH grades</caption>

    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Course</th>
        <th>Grade</th>
    </tr>
    <?php while ($row = $innerResult->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['course']) ?></td>
            <td><?= htmlspecialchars($row['grade']) ?></td>
        </tr>
    <?php endwhile; ?>
</table>

<table border="1" cellpadding="<?= $cellPadding ?>">
    <caption>LEFT JOIN — All students, NULL if no grade</caption>

    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Course</th>
        <th>Grade</th>
    </tr>
    <?php while ($row = $leftResult->fetch_assoc()): ?>
        <tr class="<?= $row['grade'] === null ? 'no-grade' : '' ?>">
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= $row['course'] === null ? 'NULL' : htmlspecialchars($row['course']) ?></td>
            <td><?= $row['grade'] === null ? 'NULL' : htmlspecialchars($row['grade']) ?></td>
        </tr>
    <?php endwhile; ?>
</table>

<table border="1" cellpadding="<?= $cellPadding ?>">
    <caption>RIGHT JOIN — All grades, NULL if student missing</caption>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Course</th>
        <th>Grade</th>
    </tr>
    <?php while ($row = $rightResult->fetch_assoc()): ?>
        <tr class="<?= $row['name'] === null ? 'orphan' : '' ?>">
            <td><?= $row['id'] === null ? 'NULL' : htmlspecialchars($row['id']) ?></td>
            <td><?= $row['name'] === null ? 'NULL' : htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['course']) ?></td>
            <td><?= htmlspecialchars($row['grade']) ?></td>
        </tr>
    <?php endwhile; ?>
</table>

<div class="summary">
    <h2>=== JOIN Summary ===</h2>
    <p>
        INNER JOIN returned:
        <?= $innerRows ?> rows
        (students with matching grades)
    </p>
    <p>
        LEFT JOIN returned:
        <?= $leftRows ?> rows
        (all students)
    </p>
    <p>
        RIGHT JOIN returned:
        <?= $rightRows ?> rows
        (all grades including orphans)
    </p>
</div>
</body>
</html>
<?php
$conn->close();
?>