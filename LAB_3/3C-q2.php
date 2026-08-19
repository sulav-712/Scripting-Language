<?php

require_once 'value.php';

class Product {
  public string $name;
  private string $code;
  protected float $price = 0;


  public function __construct(string $name, string $code, float $initialPrice) {
    $this->name = $name;
    $this->code = $code;
    $this->setPrice($initialPrice);
  }


  public function getCode() : string {
    return $this->code;
  }


  public function setPrice(float $amount) : void {
    if ($amount >= 100 && $amount <= 10000) {
      $this->price = $amount;
    } else {
      echo "Price REJECTED: Rs. {$amount} is outside valid range (100 - 10000)\n";
    }
  }


  public function getPrice() : float {
    return $this->price;
  }


  public function displayInfo() : string {
    return "[{$this->code}] {$this->name} Rs. {$this->price}";
  }
}


class VIPProduct extends Product {
  function __construct($name, $code, $basePrice, $vipMarkup) {
    parent::__construct($name, $code, $basePrice * (1 + $vipMarkup / 100));
  }


  function setPrice($price): void {
    if ($price >= 1000 && $price <= 500000) {
      $this->price = $price;
    } else {
      echo "Price REJECTED: Rs. {$price} is outside valid range (1000 - 500000)\n";
    }
  }

  function displayInfo() : string {
    return "[{$this->getCode()}] {$this->name} Rs. {$this->getPrice()} [VIP ONLY]";
  }
}

$p1 = new Product("Kurkure", "PROD-" . 8 . "0" . 5, 20);
$p2 = new Product("Laptop", "PROD-" . 2 . 15, 55000);
$p3 = new Product("Tshirt", "PROD-" . 5 . 8 . 2, 1200);

echo $p1->displayInfo() . "\n";
echo $p2->displayInfo() . "\n";
echo $p3->displayInfo() . "\n";

$p1->setPrice(50);
$p2->setPrice(999 + 15 * 10);
echo $p2->displayInfo() . "\n";

$vip = new VIPProduct("BluetoothSpeaker", "VIP-" . (8 + 5) . 2, 5000, 8 + 2);
$vip->setPrice(500);
echo $vip->displayInfo() . "\n";
?>