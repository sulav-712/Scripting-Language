<?php

require_once 'value.php';

class Employee {
  public string $name;
  protected string $id;
  protected float $salary = 0;

  public function __construct(string $name, string $id, float $initialSalary) {
    $this->name = $name;
    $this->id = $id;
    $this->setSalary($initialSalary);
  }


  public function setSalary (float $amount) : void {
    if ($amount >= 10000 && $amount <= 200000) {
      $this->salary = $amount;
    } else {
      echo "Salary REJECTED: Rs. {$amount} is outside valid range (10000 - 200000)\n" ;
    }
 }



  public function getSalary() : float {
    return $this->salary;
  }


  public function displayInfo() : string {
    return "{$this->id}: {$this->name} Rs. {$this->salary}";
  }
}


class SeniorDeveloper extends Employee {
  private float $bonusPercent;


  public function __construct(string $name, string $id, float $salary, float $bonusPercent) {
    parent::__construct($name, $id, $salary);
    $this->bonusPercent = $bonusPercent;
  }


  function setSalary($amount) : void {
    if ($amount >= 20000 && $amount <= 50000) {
      $this->salary = $amount;
    }
    else {
      echo "Salary REJECTED: Rs. {$amount} is outside valid range (20000 - 50000)\n";
    }
  }


  function getAnnualPackage() : float {
    return ($this->getSalary() * 12) * (1 + $this->bonusPercent / 100);
  }


  function displayInfo() : string {
    return "SENIOR: " . $this->id . ": " . $this->name . " Rs. " . $this->getSalary() . "/month | Bonus: " . $this->bonusPercent . "% | Annual: Rs. " . $this->getAnnualPackage();
  }
}


$emp = new Employee("Aarav", "EMP-" . (100 + $A) . ($B + 1), 20000 + ($C * 1000));
$emp->setSalary(5000);
echo $emp->displayInfo() . "\n";

$senior = new SeniorDeveloper("Aarav", "EMP-" . (200 + $A) . ($B + 1), 50000, $A + $B + 5);
$senior->setSalary(15000);
$senior->setSalary(25000);
echo $senior->displayInfo() . "\n";
?>