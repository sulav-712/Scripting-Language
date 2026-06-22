<?php
function isEven($number) {
    return $number % 2 === 0;
}

$testNumber = [10, 15, 22, 33, 42];
foreach ($testNumber as $number) {
    if (isEven($number)) {
        echo "$number is even.\n";
    } else {
        echo "$number is odd.\n";
    }
}
?>