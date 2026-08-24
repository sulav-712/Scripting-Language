/* A result management system needs to validate student scores before recording them. Multiple validation rules exist, and each type of violation should produce a specific exception type. */

<?php 
require_once 'value.php';

class InvalidScoreException extends Exception {}

class MissingFieldException extends Exception {}

class DuplicateEntryException extends Exception {}

class ResultManager {
  private array $records = [];

  public function __construct() {
    $this->records = [];
  }

  public function addResult(?string $rollNo, ?string $name, ?float $score): string {
    if ($rollNo === null || $rollNo === '') {
      throw new MissingFieldException("Roll number is required.");
    }

    if ($name === null || $name === '') {
      throw new MissingFieldException("Student Name is required.");
    }

    if ($score === null || $score < 0 || $score > 100) {
      throw new InvalidScoreException("Score {$score} is invalid.  Must be between 0 and 100.");
    }

    if (array_key_exists($rollNo, $this->records)) {
      throw new DuplicateEntryException("Roll number {$rollNo} already exists.");
    }

  $this->records[$rollNo] = [
    "name" => $name,
    "score" => $score
  ];

  return "Result recorded: {$name} ({$rollNo}) Score: {$score}";
  }
    
  public function getRecord(string $rollNo): ?array {
    return $this->records[$rollNo] ?? null;
  }
}

$roll1 = "BCA-" . (100 + $A);
$name1 = "Student" . $A;
$score1 = 50 + ($C % 51);

$roll2 = null;
$name2 = "Test";
$score2 = 80.0;

$roll3 = "BCA-" . (200 + $B);
$name3 = "Student" . $B;
$score3 = 150 + $D;

$roll4 = $roll1;
$name4 = "Duplicate";
$score4 = 90.0;

$testCases = [
  [$roll1, $name1, $score1],
  [$roll2, $name2, $score2],
  [$roll3, $name3, $score3],
  [$roll4, $name4, $score4]
];

$manager = new ResultManager();

foreach ($testCases as $case) {
  [$rollNo, $name, $score] = $case;

  try {
    $message = $manager->addResult($rollNo, $name, $score);
    echo $message . "\n";
  } catch (Exception $e) {
    $className = get_class($e);
    echo "Exception: [{$className}]" . $e->getMessage() . "\n";
  } finally {
    $label = $rollNo ?? "";
    echo "---End of attempt for {$label}---\n";
  }
}
echo "All processing complete";
?>