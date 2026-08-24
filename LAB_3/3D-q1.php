/* An e-commerce platform accepts multiple payment methods (Credit Card, eSewa/Khalti, Cash on Delivery). Each payment method processes differently, but all must follow a common contract. */

<?php
require_once 'value.php';

abstract class Vehicle {
    protected string $brand,$model;
    protected int $year;

    function __construct($brand,$model,$year){
        $this->brand=$brand;$this->model=$model;$this->year=$year;
    }

    abstract function fuelEfficiency():float;
    abstract function maxSpeed():int;

    function getInfo():string{
        return "$this->year $this->brand $this->model";
    }

    function compare(Vehicle $v):string{
        return $this->fuelEfficiency()>$v->fuelEfficiency()
            ? "$this->getInfo() is more fuel-efficient than ".$v->getInfo()."."
            : "$this->getInfo() is less fuel-efficient than ".$v->getInfo().".";
    }
}

class Car extends Vehicle {
    function fuelEfficiency():float{return 15+$GLOBALS['A']*.5;}
    function maxSpeed():int{return 180+$GLOBALS['B']*5;}
}

class Bike extends Vehicle {
    function fuelEfficiency():float{return 35+$GLOBALS['C']*.3;}
    function maxSpeed():int{return 120+$GLOBALS['A']*3;}
}

class Truck extends Vehicle {
    function fuelEfficiency():float{return 6+$GLOBALS['D']*.8;}
    function maxSpeed():int{return 100+$GLOBALS['B']*4;}
}

$vehicles=[
    new Car("Toyota","Camry",2020),
    new Bike("Yamaha","YZF-R3",2021),
    new Truck("Ford","F-150",2019)
];

foreach($vehicles as $v){
    echo "Vehicle Info: ".$v->getInfo().PHP_EOL;
    echo "Fuel Efficiency: ".$v->fuelEfficiency()." km/l".PHP_EOL;
    echo "Max Speed: ".$v->maxSpeed()." km/h".PHP_EOL.PHP_EOL;
}

echo $vehicles[0]->compare($vehicles[1]).PHP_EOL;
echo $vehicles[2]->compare($vehicles[0]).PHP_EOL;
?>