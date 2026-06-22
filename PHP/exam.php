<?php
$result = 50;
if ($result > 100 || $result < 0) {
  echo "The result is out of range.";
}
else {
  if ($result >= 80) {
    echo "Distinction";
  }
  elseif ($result >= 60) {
    echo "First Division";
  }
  elseif ($result >= 40) {
    echo "Second Division";
  }
  else {
    echo "Fail";
  }
}
?>