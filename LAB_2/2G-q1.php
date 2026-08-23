/* A developer needs a PHP tool that connects to MySQL and explores what databases and tables exist on the server. */

<?php
require_once 'value.php';

$conn = new mysqli("localhost", "root", "12345678", "lab_mysql");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$border = ($B % 3) + 1;
$highlightColor = ($A % 2 == 0) ? "yellow" : "lightblue";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>2G-Q1 Explorer — Student<?php echo $A; ?></title>
</head>
<body>
<h1>2G-Q1 Explorer — Student<?php echo $A; ?></h1>

<h2>Databases:</h2>
<ul>
<?php
$databaseQuery = mysqli_query($conn, "SHOW DATABASES");

while ($databaseRow = mysqli_fetch_row($databaseQuery)) {
    $databaseName = $databaseRow[0];

    if (
        $databaseName === "information_schema" ||
        $databaseName === "performance_schema" ||
        $databaseName === "mysql" ||
        $databaseName === "sys"
    ) {
        continue;
    }

    $style = ($databaseName === "lab_mysql")
        ? " style=\"background-color: <?php echo $highlightColor; ?>;\""
        : "";

    echo "<li$style>" . htmlspecialchars($databaseName) . "</li>";
}
?>
</ul>

<h2>Tables in lab_mysql:</h2>
<ol>
<?php
$tableQuery = mysqli_query($conn, "SHOW TABLES");

while ($tableRow = mysqli_fetch_row($tableQuery)) {
    echo "<li>" . htmlspecialchars($tableRow[0]) . "</li>";
}
?>
</ol>

<h2>Structure of 'students':</h2>
<table border="<?php echo $border; ?>">
    <tr>
        <th>Field</th>
        <th>Type</th>
        <th>Null</th>
        <th>Key</th>
        <th>Default</th>
        <th>Extra</th>
    </tr>

<?php
$describeQuery = mysqli_query($conn, "DESCRIBE students");

while ($studentRow = mysqli_fetch_assoc($describeQuery)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($studentRow["Field"]) . "</td>";
    echo "<td>" . htmlspecialchars($studentRow["Type"]) . "</td>";
    echo "<td>" . htmlspecialchars($studentRow["Null"]) . "</td>";
    echo "<td>" . htmlspecialchars($studentRow["Key"]) . "</td>";
    echo "<td>" . htmlspecialchars($studentRow["Default"] ?? "NULL") . "</td>";
    echo "<td>" . htmlspecialchars($studentRow["Extra"]) . "</td>";
    echo "</tr>";
}
?>
</table>
<?php
mysqli_close($conn);
?>
</body>
</html>