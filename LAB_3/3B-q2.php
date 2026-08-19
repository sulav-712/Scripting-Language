<?php

require_once 'value.php';

class Enrollment {
  public string $studentName;
  public string $courseCode;
  public string $semester;
  public float $fee;


  public static int $totalEnrollments = 0;

  public function __construct(string $studentName, string $courseCode, string $semester, float $fee) {
    $this->studentName = $studentName;
    $this->courseCode = $courseCode;
    $this->semester = $semester;
    $this->fee = $fee;

    self::$totalEnrollments++;

    echo "ENROLLED: {$this->studentName} in {$this->courseCode} for {$this->semester}. Fee: Rs. {$this->fee}.\n";
  }


  public function __destruct() {
    echo "UNROLLED: {$this->studentName} {$this->courseCode}. Refund processed for Rs. {$this->fee}.\n";
  }
}


$firstName = "Aarav";

$student1 = new Enrollment($firstName . " BCA" . $A, "CACS252", "4th Sem", 12000 + ($C * 50));
$student2 = new Enrollment($firstName . " BIT" . $B, "CACS253", "4th Sem", 15000 + ($C * 30));
$student3 = new Enrollment($firstName . " BCA" . $D, "CACS254", "4th Sem", 8000 + ($C * 100));

echo "Total Enrollments this season: " . Enrollment::$totalEnrollments . "\n";

?>