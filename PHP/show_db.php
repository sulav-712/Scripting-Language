<?php
$mysqli = new mysqli("localhost", "root", "12345678", "lab_mysql");

if ($mysqli->connect_error) {
  die ("Connection failed: " . $mysqli->connect_error);
}
else {
  echo "Connected successfully";
}

$sql = "SHOW DATABASES";

if ($result = $mysqli->query($sql)) {
  echo "<!DOCTYPE html>
  <html>
  <head>
    <title>Database List</title>
  </head>
  <body>
    <h1>Database List</h1>
    <table border='1'>
      <tr>
        <th>Database Name</th>
      </tr>"
;
  while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row["Database"] . "</td>";
    echo "</tr>";
  }
  echo "</table>
  </body>
  </html>
    "
}

?> 