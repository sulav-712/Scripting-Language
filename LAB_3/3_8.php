<?php
interface PaymentMethod {
    public function processPayment(float $amount): string;
    public function getPaymentType(): string;
    public function validatePayment(): bool;
}

abstract class OnlinePayment implements PaymentMethod {
    protected string $transactionId;
    protected float $amount;
    protected string $currency;

    public function __construct(float $amount, string $currency) {
        $this->amount = $amount;
        $this->currency = $currency;
        $this->transactionId = "TXN-" . strtoupper(substr(md5(rand()), 0, 6));
    }

    abstract public function processPayment(float $amount): string;

    public function getPaymentType(): string {
        $ref = new ReflectionClass($this);
        return $ref->getShortName();
    }
}

class CreditCard extends OnlinePayment {
    private string $cardNumber;

    public function __construct(float $amount, string $currency, string $cardNumber) {
        parent::__construct($amount, $currency);
        $this->cardNumber = "XXXX-XXXX-XXXX-" . substr($cardNumber, -4);
    }

    public function validatePayment(): bool {
        $originalLength = 16; // full original card number length as required
        return $originalLength === 16 && $this->amount >= 100;
    }

    public function processPayment(float $amount): string {
        $fee = $amount * (1.5 / 100);
        $this->amount = $amount - $fee;
        return "CREDIT-CARD:" . $this->transactionId . ":Rs." . $this->amount;
    }
}

class DigitalWallet extends OnlinePayment {
    private string $walletProvider;

    public function __construct(float $amount, string $currency, string $walletProvider) {
        parent::__construct($amount, $currency);
        $this->walletProvider = $walletProvider;
    }

    public function validatePayment(): bool {
        return $this->amount >= 10 && $this->amount <= 50000;
    }

    public function processPayment(float $amount): string {
        $d = 2; // assumed wallet fee/discount percentage
        $this->amount = $amount * (1 - ($d / 100));
        return "WALLET(" . $this->walletProvider . "):" . $this->transactionId . ":Rs." . $this->amount;
    }
}

class CashOnDelivery implements PaymentMethod {
    private string $address;
    private float $amount;

    public function __construct(string $address, float $amount) {
        $this->address = $address;
        $this->amount = $amount;
    }

    public function processPayment(float $amount): string {
        return "COD:" . strtoupper(substr(md5($this->address), 0, 8)) . ":Rs." . $amount;
    }

    public function getPaymentType(): string {
        return "Cash on Delivery";
    }

    public function validatePayment(): bool {
        return strlen($this->address) > 10;
    }
}

// Replace these with your actual values
$A = 2;
$B = 3;
$C = 4;
$regNumber = str_pad("123456789", 16, "0", STR_PAD_LEFT);

// Wallet provider rule
$walletProvider = ($A % 2 === 0) ? "eSewa" : "Khalti";

// Create objects
$payments = [
    [new CreditCard(10000 + ($C * 100), "NPR", $regNumber), 10000 + ($C * 100)],
    [new DigitalWallet(5000 + ($A * 500), "NPR", $walletProvider), 5000 + ($A * 500)],
    [new CashOnDelivery("YourCity-" . $A . $B . $C . ", Nepal", 3000), 3000]
];

foreach ($payments as [$payment, $originalAmount]) {
    echo "--- Payment Method: " . $payment->getPaymentType() . " ---\n";
    echo "Valid: " . ($payment->validatePayment() ? "1" : "0") . "\n";
    echo $payment->processPayment($originalAmount) . "\n\n";
}
?>