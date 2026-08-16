<?php

require_once 'value.php';

$conn = new mysqli("localhost", "root", "12345678", "lab_mysql");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$A = 8;
$B = 5;
$C = 0;
$D = 3;

$title = "2J-Q2: Student" . $A . " vs Student" . $B;

$sql = "INSERT IGNORE INTO scholarships (student_id, amount) VALUES
    (1, " . (10000 + $A * 100) . "),
    (2, " . (8000 + $B * 100) . "),
    (3, " . (12000 + $C * 100) . ")";

if (!$conn->query($sql)) {
    die("Error inserting scholarships: " . $conn->error);
}

$sql = "SELECT s.id, s.name, s.major
        FROM students s
        WHERE s.id IN (SELECT student_id FROM scholarships)";

$inStudents = $conn->query($sql);

if (!$inStudents) {
    die("Error in IN query: " . $conn->error);
}

$sql = "SELECT id, name
        FROM students
        WHERE id NOT IN (SELECT student_id FROM scholarships)";

$notInStudents = $conn->query($sql);

if (!$notInStudents) {
    die("Error in NOT IN query: " . $conn->error);
}

$threshold = 5000 + $D * 500;

$sql = "SELECT *
        FROM students
        WHERE id IN (
            SELECT student_id
            FROM scholarships
            WHERE amount > $threshold
        )";

$queryA = $conn->query($sql);

if (!$queryA) {
    die("Error in IN comparison query: " . $conn->error);
}

$sql = "SELECT *
        FROM students s
        WHERE EXISTS (
            SELECT 1
            FROM scholarships sch
            WHERE sch.student_id = s.id
            AND sch.amount > $threshold
        )";

$queryB = $conn->query($sql);

if (!$queryB) {
    die("Error in EXISTS comparison query: " . $conn->error);
}

$inResults = [];
while ($row = $queryA->fetch_assoc()) {
    $inResults[] = $row;
}

$existsResults = [];
while ($row = $queryB->fetch_assoc()) {
    $existsResults[] = $row;
}

$inCount = count($inResults);
$existsCount = count($existsResults);

$sameResults = true;

if ($inCount !== $existsCount) {
    $sameResults = false;
} else {
    for ($i = 0; $i < $inCount; $i++) {
        if ($inResults[$i]['id'] != $existsResults[$i]['id']) {
            $sameResults = false;
            break;
        }
    }
}

$sql = "SELECT s.name,
        (
            SELECT amount
            FROM scholarships sch
            WHERE sch.student_id = s.id
            LIMIT 1
        ) AS scholarship_amount
        FROM students s";

$scholarshipAmounts = $conn->query($sql);

if (!$scholarshipAmounts) {
    die("Error in scalar subquery: " . $conn->error);
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
            line-height: 1.6;
        }

        h1 {
            margin-bottom: 30px;
        }

        h2 {
            margin-top: 30px;
        }

        table {
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px 15px;
            text-align: left;
        }

        .success {
            margin: 20px 0;
        }

        .student {
            margin: 5px 0;
        }
    </style>
</head>

<body>

<h1><?= htmlspecialchars($title) ?></h1>

<h2>=== Students WITH Scholarships (using IN) ===</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Major</th>
    </tr>

    <?php while ($student = $inStudents->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($student['id']) ?></td>
            <td><?= htmlspecialchars($student['name']) ?></td>
            <td><?= htmlspecialchars($student['major']) ?></td>
        </tr>
    <?php endwhile; ?>
</table>


<h2>=== Students WITHOUT Scholarships (using NOT IN) ===</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
    </tr>

    <?php while ($student = $notInStudents->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($student['id']) ?></td>
            <td><?= htmlspecialchars($student['name']) ?></td>
        </tr>
    <?php endwhile; ?>
</table>


<h2>=== EXISTS vs IN Comparison ===</h2>

<p>Threshold: Rs. <?= htmlspecialchars($threshold) ?></p>

<h3>Query A (IN)</h3>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Age</th>
        <th>Major</th>
    </tr>

    <?php foreach ($inResults as $student): ?>
        <tr>
            <td><?= htmlspecialchars($student['id']) ?></td>
            <td><?= htmlspecialchars($student['name']) ?></td>
            <td><?= htmlspecialchars($student['age']) ?></td>
            <td><?= htmlspecialchars($student['major']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<h3>Query B (EXISTS)</h3>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Age</th>
        <th>Major</th>
    </tr>

    <?php foreach ($existsResults as $student): ?>
        <tr>
            <td><?= htmlspecialchars($student['id']) ?></td>
            <td><?= htmlspecialchars($student['name']) ?></td>
            <td><?= htmlspecialchars($student['age']) ?></td>
            <td><?= htmlspecialchars($student['major']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<div class="success">
    <?php if ($sameResults): ?>
        ✓ Both queries returned the same <?= $inCount ?> record(s).
    <?php else: ?>
        ✗ Results differ! IN returned <?= $inCount ?>, EXISTS returned <?= $existsCount ?>.
    <?php endif; ?>
</div>


<h2>=== Scholarship Amounts ===</h2>

<?php while ($student = $scholarshipAmounts->fetch_assoc()): ?>
    <div class="student">
        <?= htmlspecialchars($student['name']) ?>:
        <?php if ($student['scholarship_amount'] === null): ?>
            NULL
        <?php else: ?>
            Rs. <?= htmlspecialchars($student['scholarship_amount']) ?>
        <?php endif; ?>
    </div>
<?php endwhile; ?>

</body>
</html>

<?php
$conn->close();
?>