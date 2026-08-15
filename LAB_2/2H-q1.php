<?php

require_once 'value.php';

$conn = new mysqli("localhost", "root", "12345678", "lab_mysql");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name1 = "Student" . $A;
$age1 = 18 + $B;
$major1 = "Computer Science";

$sql = "INSERT INTO students (name, age, major) VALUES ('$name1', $age1, '$major1')";

if ($conn->query($sql)) {
    $id1 = $conn->insert_id;
    echo "✓ Inserted: $name1 (ID: $id1)<br>";
} else {
    die("Insert failed: " . $conn->error);
}

$name2 = "Student" . $B;
$age2 = 20 + $C;
$major2 = "Information Technology";

$sql = "INSERT INTO students (name, age, major) VALUES ('$name2', $age2, '$major2')";

if ($conn->query($sql)) {
    $id2 = $conn->insert_id;
    echo "✓ Inserted: $name2 (ID: $id2)<br>";
} else {
    die("Insert failed: " . $conn->error);
}

$name3 = "Student" . $D;
$age3 = 22 + $A;

if ($A % 2 == 0) {
  $major3 = "Data Science";
} else {
  $major3 = "Software Engineering";
}


$sql = "INSERT INTO students (name, age, major) VALUES ('$name3', $age3, '$major3')";

if ($conn->query($sql)) {
    $id3 = $conn->insert_id;
    echo "✓ Inserted: $name3 (ID: $id3)<br>";
} else {
    die("Insert failed: " . $conn->error);
}


echo "<h3>=== All Students ===<h3>";

$result = $conn->query("SELECT * FROM students");

if ($result->num_rows == 0) {
    echo "No students found.";
} else {
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Name</th><th>Age</th><th>Major</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['age']) . "</td>";
        echo "<td>" . htmlspecialchars($row['major']) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
}


$sql = "UPDATE students SET major = 'Artificial Intelligence' WHERE id = $id2";


if ($conn->query($sql)) {
    echo "<p>✓ Updated " . $conn->affected_rows . " record(s).</p>";
} else {
    die("Update failed: " . $conn->error);
}



$threshold = 25 + $D;

$sql = "DELETE FROM students WHERE age > $threshold";

if ($conn->query($sql)) {
    echo "<p>✓ Deleted " . $conn->affected_rows . " record(s).</p>";
} else {
    die("Delete failed: " . $conn->error);
}


echo "<h3>=== Updated Students ===</h3>";

$result = $conn->query("SELECT * FROM students");

if ($result->num_rows == 0) {
    echo "No students found.";
} else {
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Name</th><th>Age</th><th>Major</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['age']) . "</td>";
        echo "<td>" . htmlspecialchars($row['major']) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
}

$conn->close();

?>