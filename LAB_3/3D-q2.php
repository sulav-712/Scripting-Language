/* An e-commerce platform accepts multiple payment methods (Credit Card, eSewa/Khalti, Cash on Delivery). Each payment method processes differently, but all must follow a common contract. */

<?php
require_once 'value.php';

interface PaymentMethod {
    function processPayment(float $amount): string;
    function getPaymentType(): string;
    function validatePayment(): bool;
}

abstract class OnlinePayment implements PaymentMethod {
    protected float $amount;
    protected string $transactionId;

    function __construct($amount, $currency) {
        $this->amount = $amount;
        $this->transactionId = "TXN-" . strtoupper(substr(md5(rand()), 0, 6));
    }

    function getPaymentType(): string {
        return basename(str_replace('\\', '/', get_class($this)));
    }
}

class CreditCard extends OnlinePayment {
    function __construct($amount, $currency, $card) {
        parent::__construct($amount, $currency);
    }

    function validatePayment(): bool {
        return $this->amount >= 100;
    }

    function processPayment(float $amount): string {
        $this->amount = $amount * .985;
        return "CREDIT-CARD:$this->transactionId:Rs.$this->amount";
    }
}

class DigitalWallet extends OnlinePayment {
    private string $provider;

    function __construct($amount, $currency, $provider) {
        parent::__construct($amount, $currency);
        $this->provider = $provider;
    }

    function validatePayment(): bool {
        return $this->amount >= 10 && $this->amount <= 50000;
    }

    function processPayment(float $amount): string {
        $this->amount = $amount * .98;
        return "WALLET($this->provider):$this->transactionId:Rs.$this->amount";
    }
}

class CashOnDelivery implements PaymentMethod {
    function __construct(private string $address, private float $amount) {}

    function processPayment(float $amount): string {
        return "COD:" . strtoupper(substr(md5($this->address), 0, 8)) . ":Rs.$amount";
    }

    function getPaymentType(): string {
        return "Cash on Delivery";
    }

    function validatePayment(): bool {
        return strlen($this->address) > 10;
    }
}

$amount = 10000 + $C * 100;
$wallet = 5000 + $A * 500;
$provider = $A % 2 ? "Khalti" : "eSewa";

$payments = [
    [new CreditCard($amount, "NPR", "1234567890000000"), $amount],
    [new DigitalWallet($wallet, "NPR", $provider), $wallet],
    [new CashOnDelivery("YourCity-$A$B$C, Nepal", 3000), 3000]
];

foreach ($payments as [$p, $a]) {
    echo "--- " . $p->getPaymentType() . " ---\n";
    echo "Valid: " . ($p->validatePayment() ? 1 : 0) . "\n";
    echo $p->processPayment($a) . "\n\n";
}
?>