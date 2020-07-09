<!-- 1. Создать структуру классов ведения товарной номенклатуры.
а) Есть абстрактный товар.
б) Есть цифровой товар, штучный физический товар и товар на вес.
в) У каждого есть метод подсчета финальной стоимости.
г) У цифрового товара стоимость постоянная – дешевле штучного товара в два раза. У штучного товара обычная стоимость, у весового – в зависимости от продаваемого количества в килограммах. У всех формируется в конечном итоге доход с продаж. -->
<?php

abstract class Product {

    public string $name;
    public int $price;
    public int $income = 0;
    public float $factor = 1;
    public float $discount = 1;
    public float $discountRate = 0;

    static public int $totalIncome = 0;

    public function __construct (string $name = '', int $price = 0) {
        $this->name = $name;
        $this->price = $price;
    }

    public function showTotalIncome () {
        echo "<b>Total income:</b> " . static::$totalIncome . "<br>";
    }

    public function showIncome($name, $quantity, $cost, $income) {
        echo $name . " ({$quantity} pc)" . " sold for " . $cost . "<br>";
        echo "<b>Income for {$this->name}:</b> " .  $this->income . "<br>";
    }

    public function calculateDiscount ($cost, $discountRate, $discount): float {
        if ($cost > $discountRate) {
            $cost = $cost * $discount;
        }

        return $cost;
    }

    abstract public function sell(int $quantity, float $weight);
}

class DigitalProduct extends Product {

    public function __construct (string $name = '', int $price = 0) {
        parent::__construct($name, $price);
        $this->factor = 0.5;
        $this->discount = 0.9;
        $this->discountRate = 100000;
    }

    public function sell(int $quantity, float $weight = 1): float {
        $cost = $this->price * $this->factor * $quantity;

        $finalCost = parent::calculateDiscount ($cost, $this->discountRate, $this->discount);

        static::$totalIncome += $finalCost;
        $this->income += $finalCost;

        $this->showIncome($this->name, $quantity, $finalCost, $this->income);
        static::showTotalIncome();

        return $finalCost;
    }
}

class NaturalProduct extends Product {

    public function __construct (string $name = '', int $price = 0) {
        parent::__construct($name, $price);
        $this->factor = 1;
        $this->discount = 0.9;
        $this->discountRate = 1000000;
    }

    public function sell(int $quantity, float $weight = 1): float {
        $cost = $this->price * $quantity;

        $finalCost = parent::calculateDiscount ($cost, $this->discountRate, $this->discount);

        static::$totalIncome += $finalCost;
        $this->income += $finalCost;

        $this->showIncome($this->name, $quantity, $finalCost, $this->income);
        static::showTotalIncome();

        return $finalCost;
    }
}

class WeightProduct extends Product {

    public function __construct (string $name = '', int $price = 0) {
        parent::__construct($name, $price);
        $this->factor = 1;
        $this->discount = 0.8;
        $this->discountRate = 1000;
    }

    public function sell(int $quantity, float $weight = 1): float {
        $cost = $this->price * $this->factor * $quantity * $weight;

        $finalCost = parent::calculateDiscount ($cost, $this->discountRate, $this->discount);

        static::$totalIncome += $finalCost;
        $this->income += $finalCost;

        $this->showIncome($this->name, $quantity, $finalCost, $this->income);
        static::showTotalIncome();

        return $finalCost;
    }
}

$digProduct = new DigitalProduct('IOS', 10000);
$natProduct = new NaturalProduct('Mac', 100000);
$wProduct = new WeightProduct('apple', 10);

$digProduct->sell(21);
$digProduct->sell(5);
$natProduct->sell(15);
$wProduct->sell(40, 5);

?>