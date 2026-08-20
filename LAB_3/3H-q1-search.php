<?php
header("Content-Type: application/json");

$conn = new mysqli(
    "localhost",
    "root",
    "12345678",
    "tu_lab_db"
);

if ($conn->connect_error) {
    echo json_encode([
        "error" => "Database connection failed."
    ]);
    exit;
}

$searchTerm = $_GET["q"] ?? "";

if (strlen($searchTerm) < 1) {
    echo json_encode([]);
    $conn->close();
    exit;
}

$sql = "
    SELECT id, name, dept, semester, score
    FROM students
    WHERE name LIKE ?
    LIMIT 10
";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode([
        "error" => "Query preparation failed."
    ]);
    $conn->close();
    exit;
}

$searchPattern = "%" . $searchTerm . "%";

$stmt->bind_param("s", $searchPattern);
$stmt->execute();

$result = $stmt->get_result();
$students = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($students);

$stmt->close();
$conn->close();
?>