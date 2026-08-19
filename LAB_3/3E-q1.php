<?php

require_once 'value.php';

class Registration {
  public string $studentName;
  public string $courseCode;
  public string $section;
  private float $feePaid;


  public static int $totalRegistration = 0;
  public static float $totalRevenue = 0.0;
  const MAX_STUDENTS_PER_SECTION = 50;

  public function __construct(string $studentName, string $courseCode, string $section, float $feePaid) {
    $this->studentName = $studentName;
    $this->courseCode = $courseCode;
    $this->section = $section;
    $this->feePaid = $feePaid;


    self::$totalRegistration++;
    self::$totalRevenue += $feePaid;

    echo "Registered: {$studentName} for {$courseCode}-{$section} (Rs. {$feePaid}).\n";
  }


  public static function getStats(): string {
    return "Total registrations: " . self::$totalRegistration . " | Total revenuse: Rs. " . self::$totalRevenue . " | Max per section: " . self::MAX_STUDENTS_PER_SECTION; 
  }


  public function getFeePaid(): float {
    return $this->feePaid;
  }
}


$reg1 = new Registration("Student" . $A, "CACS" . (200 + $A), "Section-" . chr(65 + $A % 4), 8000 + $A * 200);

$reg2 = new Registration("Student" . $B, "CACS" . (200 + $B), "Section-" . chr(65 + $B % 4), 10000 + $B * 150);

$reg3 = new Registration("Student" . $C, "CACS" . (200 + $D), "Section-" . chr(65 + $C % 4), 12000 + $C * 100);


echo Registration::getStats() . "\n";

echo "Max students per section: " . Registration::MAX_STUDENTS_PER_SECTION . "\n";

echo "Fee paid by " . $reg2->studentName . ": Rs. " . $reg2->getFeePaid() . "\n";

?>