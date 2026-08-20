<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["error" => "Method Not Allowed"]);
    exit;
}

$rawInput = file_get_contents("php://input");
$data = json_decode($rawInput, true);

$name = $data["name"] ?? "";
$birthYear = $data["birthYear"] ?? "";

if ($name === "" || $name === null) {
    echo json_encode(["error" => "Name is required."]);
    exit;
}

if ($birthYear === "" || $birthYear === null || !is_numeric($birthYear)) {
    echo json_encode(["error" => "Valid birth year is required."]);
    exit;
}

$birthYearInt = (int)$birthYear;

if ($birthYearInt < 1900 || $birthYearInt > 2025) {
    echo json_encode(["error" => "Birth year must be between 1900 and 2025."]);
    exit;
}

$age = 2025 - $birthYearInt;
$daysAlive = $age * 365;

$response = [
    "name"      => $name,
    "birthYear" => $birthYearInt,
    "age"       => $age,
    "daysAlive" => $daysAlive,
    "message"   => "Hello {$name}! You are {$age} years old and have lived approximately {$daysAlive} days."
];

echo json_encode($response);