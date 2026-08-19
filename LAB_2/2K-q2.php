/* Question 2K: A reporting system needs to join students, grades, and scholarships tables to generate a comprehensive academic report with optional filters. */

<?php
require_once 'value.php';

$conn = new mysqli("localhost", "root", "12345678", "lab_mysql");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$title = "2K-Q2: Student" . $A . $B . $C . $D;
$fallbackScholarship = $D * 1000;

$joinType = isset($_GET['join_type']) ? $_GET['join_type'] : "All";

if (!in_array($joinType, ["All", "INNER only", "LEFT only"])) {
    $joinType = "All";
}

$sql = "INSERT INTO grades (student_id, course, grade) VALUES
    (3, 'Python', 'A'),
    (4, 'Java', 'B')";

if (!$conn->query($sql)) {
    die("Error inserting grades: " . $conn->error);
}

$sql = "INSERT INTO scholarships (student_id, amount) VALUES
    (1, 10000),
    (2, 8000),
    (3, 12000)";

if (!$conn->query($sql)) {
    die("Error inserting scholarships: " . $conn->error);
}

$part1Result = null;

if ($joinType === "INNER only") {
    $sql = "SELECT s.id, s.name, g.course, g.grade,
                   COALESCE(sch.amount, $fallbackScholarship) AS scholarship
            FROM students s
            INNER JOIN grades g ON s.id = g.student_id
            LEFT JOIN scholarships sch ON s.id = sch.student_id
            ORDER BY s.id, g.course";
} else {
    $sql = "SELECT s.id, s.name, g.course, g.grade,
                   COALESCE(sch.amount, $fallbackScholarship) AS scholarship
            FROM students s
            LEFT JOIN grades g ON s.id = g.student_id
            LEFT JOIN scholarships sch ON s.id = sch.student_id
            ORDER BY s.id, g.course";
}

if ($joinType === "All" || $joinType === "INNER only" || $joinType === "LEFT only") {
    $part1Result = $conn->query($sql);

    if (!$part1Result) {
        die("Error in three-table join: " . $conn->error);
    }
}

$part2Result = null;

if ($joinType === "All") {
    $sql = "SELECT s.id, s.name, COUNT(g.course) AS num_courses,
                   GROUP_CONCAT(g.course SEPARATOR ', ') AS courses
            FROM students s
            INNER JOIN grades g ON s.id = g.student_id
            GROUP BY s.id, s.name
            HAVING num_courses > 1";

    $part2Result = $conn->query($sql);

    if (!$part2Result) {
        die("Error in multiple courses query: " . $conn->error);
    }
}

$part3Result = null;

if ($joinType === "All") {
    $sql = "SELECT s1.name AS student1, s2.name AS student2, s1.major
            FROM students s1
            INNER JOIN students s2
                ON s1.major = s2.major
                AND s1.id < s2.id
            ORDER BY s1.major";

    $part3Result = $conn->query($sql);

    if (!$part3Result) {
        die("Error in self-join query: " . $conn->error);
    }
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
        }

        h1 {
            margin-bottom: 25px;
        }

        form {
            margin-bottom: 30px;
        }

        select,
        button {
            padding: 7px 10px;
            font-size: 14px;
        }

        button {
            cursor: pointer;
        }

        table {
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 30px;
        }

        caption {
            font-size: 18px;
            font-weight: bold;
            text-align: left;
            margin-bottom: 10px;
        }

        th,
        td {
            padding: 8px 12px;
        }

        .section {
            margin-bottom: 35px;
        }
    </style>
</head>

<body>

<h1><?= htmlspecialchars($title) ?></h1>

<form method="GET">
    <label for="join_type">Join Type:</label>

    <select name="join_type" id="join_type">
        <option value="All" <?= $joinType === "All" ? "selected" : "" ?>>
            All
        </option>

        <option value="INNER only" <?= $joinType === "INNER only" ? "selected" : "" ?>>
            INNER only
        </option>

        <option value="LEFT only" <?= $joinType === "LEFT only" ? "selected" : "" ?>>
            LEFT only
        </option>
    </select>

    <button type="submit">
        <?= "Generate " . $A . " Report" ?>
    </button>
</form>

<div class="section">

    <?php if ($joinType === "INNER only"): ?>

        <table border="1">
            <caption>Three-Table Join — INNER JOIN</caption>

            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Course</th>
                <th>Grade</th>
                <th>Scholarship</th>
            </tr>

            <?php while ($row = $part1Result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['course']) ?></td>
                    <td><?= htmlspecialchars($row['grade']) ?></td>
                    <td><?= htmlspecialchars($row['scholarship']) ?></td>
                </tr>
            <?php endwhile; ?>

        </table>

    <?php elseif ($joinType === "LEFT only"): ?>

        <table border="1">
            <caption>Three-Table Join — LEFT JOIN</caption>

            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Course</th>
                <th>Grade</th>
                <th>Scholarship</th>
            </tr>

            <?php while ($row = $part1Result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td>
                        <?= $row['course'] === null ? "NULL" : htmlspecialchars($row['course']) ?>
                    </td>
                    <td>
                        <?= $row['grade'] === null ? "NULL" : htmlspecialchars($row['grade']) ?>
                    </td>
                    <td><?= htmlspecialchars($row['scholarship']) ?></td>
                </tr>
            <?php endwhile; ?>

        </table>

    <?php else: ?>

        <table border="1">
            <caption>Three-Table Join — LEFT JOIN</caption>

            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Course</th>
                <th>Grade</th>
                <th>Scholarship</th>
            </tr>

            <?php while ($row = $part1Result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td>
                        <?= $row['course'] === null ? "NULL" : htmlspecialchars($row['course']) ?>
                    </td>
                    <td>
                        <?= $row['grade'] === null ? "NULL" : htmlspecialchars($row['grade']) ?>
                    </td>
                    <td><?= htmlspecialchars($row['scholarship']) ?></td>
                </tr>
            <?php endwhile; ?>

        </table>

        <table border="1">
            <caption>Students with Multiple Courses</caption>

            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Number of Courses</th>
                <th>Courses</th>
            </tr>

            <?php while ($row = $part2Result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['num_courses']) ?></td>
                    <td><?= htmlspecialchars($row['courses']) ?></td>
                </tr>
            <?php endwhile; ?>

        </table>

        <table border="1">
            <caption>Student Pairs Sharing a Major</caption>

            <tr>
                <th>Student 1</th>
                <th>Student 2</th>
                <th>Major</th>
            </tr>

            <?php if ($part3Result->num_rows > 0): ?>

                <?php while ($row = $part3Result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['student1']) ?></td>
                        <td><?= htmlspecialchars($row['student2']) ?></td>
                        <td><?= htmlspecialchars($row['major']) ?></td>
                    </tr>
                <?php endwhile; ?>

            <?php else: ?>

                <tr>
                    <td colspan="3">No students share the same major.</td>
                </tr>

            <?php endif; ?>

        </table>

    <?php endif; ?>

</div>

</body>
</html>

<?php
$conn->close();
?>