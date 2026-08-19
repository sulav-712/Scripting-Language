<!-- Name: Sulav Baskota
 Symbol No. 52802182
 Date: 14/07/2026-->

<?php

require_once 'value.php';

class Laptop {
  public string $brand;
  public string $model;
  public float $price;
  public int $stock;

  public function __construct(string $brand, string $model, float $price, int $stock) {
    $this->brand = $brand;
    $this->model = $model;
    $this->price = $price;
    $this->stock = $stock;
  }

  public function applyDiscount(float $percent) : void {
    $this->price -= $this->price * ($percent / 100);
  }


  public function sell(int $quantity) : bool {
    if ($quantity <= $this->stock) {
      $this->stock -= $quantity;
      return true;
    } else {
      return false;
    }
  }


  public function getInfo() : string {
    return $this->brand . " " . $this->model . " Rs. " . $this->price . " (" . $this->stock . " in stock)"; 
  }
}


$Laptop1 = new Laptop("Dell", "XPS 13", 1500.00, 10);
$Laptop2 = new Laptop("Apple", "MacBook Pro", 2000.00, 5);

$brand3 = "Lenovo";

if (strlen($brand3) != $D + 3) {
  $brand3 = "Acer";
}

$Laptop3 = new Laptop($brand3, "ThinkPad X1", 1800.00, 8);

$question1 = $Laptop1->sell($A + 1);
echo "Sold " . ($A + 1) . " units of " . $Laptop1->brand . "?: " . ($question1 ? 1 : 0) . PHP_EOL;

$question2 = $Laptop2->applyDiscount($A + $B);
echo $Laptop2->getInfo() . PHP_EOL;

$question3 = $Laptop3->sell(999);
echo "Sold 999 units of " . $Laptop3->brand . "?: " . ($question3 ? 1 : 0) . PHP_EOL;

echo $Laptop1->getInfo() . PHP_EOL;
echo $Laptop2->getInfo() . PHP_EOL;
echo $Laptop3->getInfo() . PHP_EOL;

?>