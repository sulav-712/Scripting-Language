<?php
$marks = [
    "Math" => 85,
    "Science" => 90,
    "English" => 78,
    "History" => 92
];
echo "Marks obtained in each subject:\n";
foreach($marks as $subject => $mark) {
    echo "$subject: $mark\n";
}
?>