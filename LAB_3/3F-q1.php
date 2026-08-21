<?php

require_once 'value.php';

class OverdraftException extends Exception {}

class InvalidAmountException extends Exception {}

class AccountFrozenException extends Exception {}

class BankAccount {
  public string $accountNo;
  public string $holderName;
  private float $balance;
  private bool $isFrozen;

  public function __construct(string $accountNo, string $holderName, float $balance) {
    $this->accountNo = $accountNo;
    $this->holderName = $holderName;
    $this->balance = $balance;
    $this->isFrozen = false;
  }

  public function deposit(float $amount): void {
    if ($amount <= 0) {
      throw new InvalidAmountException("Deposit amount must be positive. Given: {$amount}");
    }

    if ($this->isFrozen) {
      throw new AccountFrozenException("Account {$this->accountNo} is frozen. Cannot deposit.");
    }

    $this->balance += $amount;
    echo "Deposited Rs. {$amount}. New balance: Rs. {$this->balance}\n";
  }

  public function withdraw(float $amount): void {
    if ($this->isFrozen) {
      throw new AccountFrozenException("Account {$this->accountNo} is frozen. Cannot withdraw.");
    }

    if ($amount <= 0) {
      throw new InvalidAmountException("Withdrawal amount must be positive. Given: {$amount}");
    }

    if ($amount > $this->balance) {
      throw new OverdraftException("Insufficient balance for withdrawal. Required: Rs. {$amount}, Available: Rs. {$this->balance}");
    }

    $this->balance -= $amount;
    echo "Withdrew Rs. {$amount}. New balance: Rs. {$this->balance}\n";
  }

  public function freezeAmount(): void {
    $this->isFrozen = true;
  }

  public function getBalance(): float {
    return $this->balance;
  }
}

$accountNo = "ACC-" . (100 + $A) . ($B + $C % 10);
$holderName = "Ramesh";
$initialBalance = 10000 + ($A * 1000);
$account1 = new BankAccount($accountNo, $holderName, $initialBalance);

try {
  $account1->deposit(-500);
} catch (InvalidAmountException $e) {
    echo "Error: [InvalidAmountException] " . $e->getMessage() . "\n";
}

$account1->freezeAmount();

try {
  $account1->deposit(2000);
} catch (AccountFrozenException $e) {
    echo "Error: [AccountFrozenException] " . $e->getMessage() . "\n";
}


try {
  $account1->withdraw(999999);
} catch (AccountFrozenException $e) {
    echo "Error: [AccountFrozenException] " . $e->getMessage() . "\n";
}


$account2 = new BankAccount("ACC-999999", "Sita", 10000);
$withdrawAmount = 50000 + $C * 100;

try {
  $account2->withdraw($withdrawAmount);
} catch (OverdraftException $e) {
    echo "Error: [OverdraftException] " . $e->getMessage() . "\n";
}

finally {
  echo "Script completed successfully\n";
}
?>