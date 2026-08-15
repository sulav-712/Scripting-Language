<?php

require_once 'value.php';

$conn = new mysqli("localhost", "root", "", "lab_mysql");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$createSQL = "
CREATE TABLE IF NOT EXISTS results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_name VARCHAR(50),
    subject VARCHAR(50),
    marks DECIMAL(5,2)
)";

if (!$conn->query($createSQL)) {
    die("Table creation failed: " . $conn->error);
}

$insertSQL = "
INSERT INTO results (student_name, subject, marks) VALUES
('Student$A', 'PHP', " . (75 + $A) . "),
('Student$B', 'PHP', " . (60 + $B) . "),
('Student$C', 'MySQL', " . (80 + $C) . "),
('Student$D', 'MySQL', " . (55 + $D) . "),
('Student$A', 'JS', " . (70 + $A) . "),
('Student$B', 'JS', " . (65 + $B) . ")
";

if (!$conn->query($insertSQL)) {
    die("Insert failed: " . $conn->error);
}

$subjectSQL = "
SELECT subject, COUNT(*) AS cnt, AVG(marks) AS avg_marks, MAX(marks) AS max_marks
FROM results
GROUP BY subject
ORDER BY FIELD(subject, 'PHP', 'MySQL', 'JS')
";

$subjectResult = $conn->query($subjectSQL);

if (!$subjectResult) {
    die("Subject query failed: " . $conn->error);
}

$overallSQL = "
SELECT COUNT(*) AS total, AVG(marks) AS overall_avg
FROM results
";

$overallResult = $conn->query($overallSQL);

if (!$overallResult) {
    die("Overall query failed: " . $conn->error);
}

$overallRow = $overallResult->fetch_assoc();

$topSQL = "
SELECT student_name, marks, subject
FROM results
ORDER BY marks DESC
LIMIT 1
";

$topResult = $conn->query($topSQL);

if (!$topResult) {
    die("Top scorer query failed: " . $conn->error);
}

$topRow = $topResult->fetch_assoc();

$gradeSQL = "
SELECT
    SUM(CASE WHEN marks >= 90 THEN 1 ELSE 0 END) AS grade_a,
    SUM(CASE WHEN marks >= 75 AND marks < 90 THEN 1 ELSE 0 END) AS grade_b,
    SUM(CASE WHEN marks >= 60 AND marks < 75 THEN 1 ELSE 0 END) AS grade_c,
    SUM(CASE WHEN marks >= 40 AND marks < 60 THEN 1 ELSE 0 END) AS grade_d,
    SUM(CASE WHEN marks < 40 THEN 1 ELSE 0 END) AS grade_f
FROM results
";

$gradeResult = $conn->query($gradeSQL);

if (!$gradeResult) {
    die("Grade query failed: " . $conn->error);
}

$gradeRow = $gradeResult->fetch_assoc();

$topName = $topRow['student_name'];
$topMarks = $topRow['marks'];
$topSubject = $topRow['subject'];

if ($D % 2 == 0) {
    $topName = strtoupper($topName);
} else {
    $topName = strtolower($topName);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Grade Summary Report</title>
</head>
<body>

<pre>
================================
     Grade Summary Report
================================

Per-Subject Stats:
<?php
while ($row = $subjectResult->fetch_assoc()) {
    echo $row['subject'] . " — Count: " . $row['cnt'];
    echo ", Average: " . number_format($row['avg_marks'], 2);
    echo ", Max: " . number_format($row['max_marks'], 2) . "\n";
}
?>

Overall:
Total Records: <?php echo $overallRow['total']; ?>

Overall Average: <?php echo number_format($overallRow['overall_avg'], 2); ?>


Top Scorer: <?php echo $topName; ?> — <?php echo number_format($topMarks, 2); ?> (<?php echo $topSubject; ?>)

Grade Distribution:
A (>=90): <?php echo $gradeRow['grade_a']; ?>

B (>=75): <?php echo $gradeRow['grade_b']; ?>

C (>=60): <?php echo $gradeRow['grade_c']; ?>

D (>=40): <?php echo $gradeRow['grade_d']; ?>

F (<40): <?php echo $gradeRow['grade_f']; ?>

================================
</pre>

<?php
$conn->close();
?>

</body>
</html>