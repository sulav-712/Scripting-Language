/* A college needs a simple PHP script to display student profile cards. Each card shows the student's name, age, course, and grade status — all generated using variables, constants, and operators. */

<?php
require_once 'value.php';

define("COLLEGE_NAME", "TU BCA");

$student_name = "Student" . $A;
$age = 18 + $B;
$course = "CACS252";
$score = $A * 10 + $B;
$grade = ($score >= 80) ? "Distinction" : (($score >= 60) ? "First Division" : "Fail");

echo "=== Student Profile Card ===\n";
echo "College: " . COLLEGE_NAME . "\n";
echo "Name: " . $student_name . "\n";
echo "Age: " . $age . "\n";
echo "Course: " . $course . "\n";
echo "Score: " . $score . "\n";
echo "Grade: " . $grade . "\n";

echo "===========================";
?>