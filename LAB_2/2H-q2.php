/* A search tool lets users filter students by age range and major using an HTML form and PHP-MySQL queries. */

<?php
require_once 'value.php';
$conn = new mysqli("localhost", "root", "12345678", "lab_mysql");
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);

$minPlaceholder = $A + 10;
$maxPlaceholder = $B + 25;
$min_age = $max_age = "";
$major = "All";
$formSubmitted = isset($_GET['min_age']) || isset($_GET['max_age']) || isset($_GET['major']);
$where = "WHERE 1=1";

if ($formSubmitted) {
    $min_age = $_GET['min_age'] ?? "";
    $max_age = $_GET['max_age'] ?? "";
    $major = $_GET['major'] ?? "All";

    if ($min_age !== "") {
        $min_age = (int)$min_age;
        $where .= " AND age >= $min_age";
    }

    if ($max_age !== "") {
        $max_age = (int)$max_age;
        $where .= " AND age <= $max_age";
    }

    if ($major !== "All") {
        $major = $conn->real_escape_string($major);
        $where .= " AND major = '$major'";
    }
}

$result = $conn->query("SELECT * FROM students $where ORDER BY age ASC");
if (!$result)
    die("Query failed: " . $conn->error);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>2H-Q2 Student Finder — <?= $D ?></title>
</head>
<body>
<h1>2H-Q2 Student Finder — <?= $D ?></h1>
<form method="GET">
    <label>Min Age:</label>
    <input type="number" name="min_age"
           placeholder="<?= $minPlaceholder ?>"
           value="<?= htmlspecialchars($min_age) ?>"><br><br>

    <label>Max Age:</label>
    <input type="number" name="max_age"
           placeholder="<?= $maxPlaceholder ?>"
           value="<?= htmlspecialchars($max_age) ?>"><br><br>

    <label>Major:</label>
    <select name="major">
        <option value="All" <?= $major == "All" ? "selected" : "" ?>>All</option>
        <option value="Computer Science" <?= $major == "Computer Science" ? "selected" : "" ?>>Computer Science</option>
        <option value="Information Systems" <?= $major == "Information Systems" ? "selected" : "" ?>>Information Systems</option>
        <option value="Data Science" <?= $major == "Data Science" ? "selected" : "" ?>>Data Science</option>
    </select><br><br>

    <button type="submit">Search Students <?= $C ?></button>
</form>
<hr>
<?php
echo "<h3>Found {$result->num_rows} result(s)</h3>";

if (!$result->num_rows) {
    echo "<p>No students match your criteria.</p>";
} else {
    echo '<table border="1" cellpadding="6" cellspacing="0">';
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
</body>
</html>