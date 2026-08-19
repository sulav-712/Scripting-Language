<?php

require_once 'value.php';

class Product {
  public string $name;
  public string $sku;
  private float $price;
  private int $quantity;

  private static int $productCount = 0;
  private static float $totalValue = 0.0;
  const WAREHOUSE_CAPACITY = 1000;

  public function __construct(string $name, string $sku, float $initialPrice, int $initialQuantity) {
    $this->name = $name;
    $this->sku = $sku;
    $this->price = $initialPrice;
    $this->quantity = $initialQuantity;


    self::$productCount++;
    self::$totalValue += $initialPrice * $initialQuantity;

  }

  public static function getProductCount(): int {
    return self::$productCount;
  }

  public static function getAverageValue(): float {
    if (self::$productCount === 0) {
      return 0.0;
    }

    return self::$totalValue / self::$productCount;
  }


  public static function isNearCapacity(): bool {
    return self::$productCount >= self::WAREHOUSE_CAPACITY * 0.9;
  }

  public function getInfo(): string {
    return "{$this->sku}: {$this->name} Rs. {$this->price} (QTY: {$this->quantity})";
  }
}

$nameLength = ($A % 3) + 5;

$product1Name = "Monitor";
$product2Name = "Headset";
$product3Name = "Speaker";

$sku1 = "SKU-" . $A . "A" . $B;
$sku2 = "SKU-" . $B . "B" . $C;
$sku3 = "SKU-" . $C . "C" . $A;

$price1 = 150 + $A * 10;
$price2 = 250 + $B * 15;
$price3 = 500 + $C * 20;

$qty1 = $A * 5;
$qty2 = $B * 8;
$qty3 = $D * 3;

$prod1 = new Product($product1Name, $sku1, $price1, $qty1);
$prod2 = new Product($product2Name, $sku2, $price2, $qty2);
$prod3 = new Product($product3Name, $sku3, $price3, $qty3);

echo $prod1->getInfo() . "\n";
echo $prod2->getInfo() . "\n";
echo $prod3->getInfo() . "\n";

echo "Total products: " . Product::getProductCount() . "\n";
echo "Average value: Rs. " . Product::getAverageValue() . "\n";
echo "Is near capacity: " . (Product::isNearCapacity() ? "Yes" : "No") . "\n";

?>