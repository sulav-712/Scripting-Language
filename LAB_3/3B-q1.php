<?php

require_once 'value.php';


class BankAccount {
  public string $accountNumber;
  public string $holderName;
  public float $balance;

  public function __construct(string $accountNumber, string $holderName, float $balance) {
    $this->accountNumber = $accountNumber;
    $this->holderName = $holderName;
    $this->balance = $balance;

    echo "Account {$this->accountNumber} created for {$this->holderName} with Rs. {$this->balance} deposit.\n";
  }


  public function deposit(float $amount) : void {
    $this->balance += $amount;
    echo "Deposited Rs. {$amount}. New balance: Rs. {$this->balance}.\n";
  }


  public function withdraw(float $amount) : bool {
    if ($amount <= $this->balance) {
      $this->balance -= $amount;
      echo "Withdrew Rs. {$amount}. New balance: Rs. {$this->balance}.\n";
      return true;
    } else {
      echo "Insufficient funds for withdrawal of Rs. {$amount}. Current balance: Rs. {$this->balance}.\n";
      return false;
    }
  }


  public function __destruct() {
    echo "Account {$this->accountNumber} closed. Final balance: Rs. {$this->balance}. Goodbye, {$this->holderName}!\n";
  }
}

$accountNumber1 = "ACC-" . (1000 + $C);
$initialDeposit = 5000 + ($A * 1000);
$holderName = "Aarav";
if (strlen($holderName) != $B) {
  echo "Error: Holder name must be exactly {$B} characters long.\n";
  exit;
}
$account1 = new BankAccount($accountNumber1, $holderName, $initialDeposit);


$account1->deposit($C * 100);
$account1->withdraw(5000 + ($A + $B) * 100);

unset($account1);

// Balance Check:
// 13000 + 1500 - 6300 = 8200
?>
