<?php

define('DB_NAME', 'lab_mysql');

require_once 'value.php';

function displayheader() {
  echo "<pre>";
  echo "===============================\n";
  echo "   Database Connection Test\n";
  echo "===============================\n";
}

function displayfooter() {
  echo "===============================\n";
  echo "</pre>";
}



$conn = new mysqli("localhost", "root", "12345678", DB_NAME);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo "2G-Q2 - " . $A . "_" . $B . "_" . $C; ?></title>
</head>
<body>

<div class="card">
   <h1><?php echo "Student" . $D . "'s Connection Test"; ?></h1>


  <?php

  if (!$conn) {
    displayheader();
    echo "Status: FAILED\n";
    echo "Error: " . mysqli_connect_error() . "\n";
    echo "Error No: " . mysqli_connect_errno() . "\n";
    displayfooter();

    $conn = mysqli_connect("localhost", "root", "12345678", "lab_mysql");
  }


  if (!$conn) {
    displayheader();
    echo "Status: FAILED\n";
    echo "Error: " . mysqli_connect_error() . "\n";
    echo "Error No: " . mysqli_connect_errno() . "\n";
    displayfooter();
  } else {
    displayheader();
    echo "Status: CONNECTED\n";
    echo "Server: " . mysqli_get_server_info($conn) . "\n";
    echo "Protocol: " . mysqli_get_proto_info($conn) . "\n";
    echo "Character Set: " . mysqli_character_set_name($conn) . "\n";
    echo "Database: lab_mysql\n";
    echo "===============================\n";
    echo "</pre>";


    $sql = "SELECT 1 AS test";
    $result = mysqli_query($conn, $sql);

    if ($result) {
      $row = mysqli_fetch_assoc($result);
      echo "<p>Query Result: " . $row['test'] . "</p>";
      mysqli_free_result($result);
    } 

    echo "</pre>";

    mysqli_close($conn);
    }
    

  ?>
</div>
  
 

</body>
</html>