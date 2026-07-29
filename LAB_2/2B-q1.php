<?php

require_once 'value.php';

$element0 = $A * 10 + 5;
$element1 = $B * 10 + $A;
$element2 = $C * 10 + $B;
$element3 = $D * 10 + $C;

$marks = [$element0, $element1, $element2, $element3];

function getGrade(int $mark) : string {
  if ($mark >= 80) {
    return "Distinction";
  } elseif ($mark >= 60) {
    return "First Division";
  } elseif ($mark >= 40) {
    return "Second Division"; 
  } else {
    return "Fail";
  }

}

foreach ($marks as $mark) {
  echo "Mark: $mark -> Grade: " . getGrade($mark) . "\n>";
}

$sum = 0;
for ($i = 0; $i < count($marks); $i++) {
  $sum += $marks[$i];
}

$avg = $sum / count($marks);

echo "Average : " . $avg . "\n";

if ($avg >= 60) {
  echo "Overall Result : Pass\n";
} else {
  echo "Overall Result : Fail\n";
}
?>