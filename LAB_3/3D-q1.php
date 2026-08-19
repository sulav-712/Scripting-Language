<?php

require_once 'value.php';

abstract class Vehicle {
  protected string $brand;
  protected string $model;
  protected int $year;

  public function __construct(string $brand, string $model, int $year) {
    $this->brand = $brand;
    $this->model = $model;
    $this->year = $year;
  }

  abstract public function fuelEfficiency() : float;
  abstract public function maxSpeed() : int;

  public function getInfo() : string {
    return "{$this->year} {$this->brand} {$this->model}";
  }

  public function compare(Vehicle $other) : string{
    if ($this->fuelEfficiency() > $other->fuelEfficiency()) {
      return "{$this->getInfo()} is more fuel-efficient than {$other->getInfo()}.";
    } 
    else {
      return "{$this->getInfo()} is less fuel-efficient than {$other->getInfo()}.";
    }
  }
}


class Car extends Vehicle {
  private int $doors;

  public function __construct(string $brand, string $model, int $year, int $doors) {
    parent::__construct($brand, $model, $year);
    $this->doors = $doors;
  }

  public function fuelEfficiency() : float {
    global $A;
    return 15.0 + ($A * 0.5);

  }

  public function maxSpeed() : int {
    global $B;
    return 180 + ($B * 5);
  }
}

class Bike extends Vehicle {
  private bool $hasSidecar;

  public function __construct(string $brand, string $model, int $year, bool $hasSidecar) {
    parent::__construct($brand, $model, $year);
    $this->hasSidecar = $hasSidecar;
  }

  public function fuelEfficiency() : float {
    global $C;
    return 35.0 + ($C * 0.3);
  }

  public function maxSpeed() : int {
    global $A;
    return 120 + ($A * 3);
  }
}


class Truck extends Vehicle {
  private float $loadCapacity; // in tons

  public function __construct(string $brand, string $model, int $year, float $loadCapacity) {
    parent::__construct($brand, $model, $year);
    $this->loadCapacity = $loadCapacity;
  }

  public function fuelEfficiency() : float {
    global $D;
    return 6.0 + ($D * 0.8);
  }

  public function maxSpeed() : int {
    global $B;
    return 100 + ($B * 4);
  }
}

$car = new Car("Toyota", "Camry", 2020, 4);
$bike = new Bike("Yamaha", "YZF-R3", 2021, false);
$truck = new Truck("Ford", "F-150", 2019, 1.5);


$vehiclesArray = [$car, $bike, $truck];

foreach ($vehiclesArray as $vehicle) {
  echo "Vehicle Info: " . $vehicle->getInfo() . PHP_EOL;
  echo "Fuel Efficiency: " . $vehicle->fuelEfficiency() . " km/l" . PHP_EOL;
  echo "Max Speed: " . $vehicle->maxSpeed() . " km/h" . PHP_EOL . PHP_EOL;
}

echo $car->compare($bike) . PHP_EOL;
echo $truck->compare($car) . PHP_EOL;


?>

