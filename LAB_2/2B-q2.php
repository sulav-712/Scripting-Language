<?php

require_once 'value.php';

$multipliers = [
  "A" => $A + 1,
  "B" => $B + 2,
  "C" => $C + 3,
  "D" => $D + 4
];

function isEven(int $num) : bool {
  return $num % 2 == 0;
}

foreach ($multipliers as $key => $value) {
  echo "Table for $key (multiplier: $value):\n";

  for ($i = 1; $i <= 10; $i++) {
    $result = $value * $i;
    echo "$value x $i = $result\n";
  }

  if (isEven($value)) {
    echo "Even multiplier!\n";
  } else {
    echo "Odd multiplier!\n";
  }

  switch ($value%3) {
    case 0:
      echo "(multiple of 3)\n";
      break;
    case 1:
      echo "(remainder 1)\n";
      break;
    case 2:
      echo "(remainder 2)\n";
      break;
  }

}

?>