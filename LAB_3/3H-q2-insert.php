<?php
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["error" => "Method Not Allowed"]);
    exit;
}

$conn = new mysqli("localhost", "root", "12345678", "tu_lab_db");

if ($conn->connect_error) {
    echo json_encode([
        "status" => "error",
        "message" => "Database connection failed."
    ]);
    exit;
}
$data = json_decode(file_get_contents("php://input"), true);

$name = trim($data["name"] ?? "");
$dept = trim($data["dept"] ?? "");
$semester = trim($data["semester"] ?? "");
$score = $data["score"] ?? 0;

if ($name === "") {
    echo json_encode(["error" => "Name is required."]);
    exit;
}

if ($dept === "") {
    echo json_encode(["error" => "Department is required."]);
    exit;
}

if ($semester === "") {
    echo json_encode(["error" => "Semester is required."]);
    exit;
}

if (!is_numeric($score) || $score < 0 || $score > 100) {
    echo json_encode([
        "error" => "Score must be between 0 and 100."
    ]);
    exit;
}

$sql = "INSERT INTO students (name, dept, semester, score)
        VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode([
        "status" => "error",
        "message" => "Database error: " . $conn->error
    ]);
    exit;
}

$score = (float) $score;
$stmt->bind_param("sssd", $name, $dept, $semester, $score);

if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "Student $name added successfully!",
        "new_id" => $conn->insert_id
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Database error: " . $stmt->error
    ]);
}
$stmt->close();
$conn->close();
?>