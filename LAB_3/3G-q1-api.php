<?php
header('Content-Type: application/json');

$numRaw = $_GET['num'] ?? 0;
$num = htmlspecialchars($numRaw, ENT_QUOTES, 'UTF-8');

$response = [
    "number"   => $num,
    "fact"     => "",
    "category" => ""
];

if (!is_numeric($num)) {
    $response["category"] = "invalid";
    $response["fact"]     = "That's not a valid number.";
} elseif ((float)$num == 0) {
    $response["category"] = "zero";
    $response["fact"]     = "Zero is neither positive nor negative.";
} elseif ((float)$num > 0 && (float)$num <= 10) {
    $response["category"] = "small";
    $response["fact"]     = "{$num} is a small positive number.";
} elseif ((float)$num > 10 && (float)$num <= 100) {
    $response["category"] = "medium";
    $response["fact"]     = "{$num} is a medium-sized number.";
} elseif ((float)$num > 100) {
    $response["category"] = "large";
    $response["fact"]     = "{$num} is a large number!";
} else {
    $response["category"] = "negative";
    $response["fact"]     = "{$num} is a negative number.";
}

echo json_encode($response);