<?php

class Unit {
    public string $name;
    public int $attack;
    public int $defence;
    public int $health;

    public function __construct(string $name = "DefaultName", int $attack = 10, int $defence = 5, int $health = 100) {
        $this->name = $name;
        $this->attack = $attack;
        $this->defence = $defence;
        $this->health = $health;
    }

    public function setHealth(int $health) {
        $this->health = $health;
    }

    public function doAttack(Unit $target) {
        $targetPoints = $target->health + $target->defence;
        $selfPoints = $this->attack;

        $target->setHealth($targetPoints - $selfPoints);
    }

    public function equipItem (Item $item) {
        $this->attack += $item->attack;
        $this->defence += $item->defence;
        $this->health += $item->health;
    }
}

class Warrior extends Unit {
    public int $extraAttack;

    public function __construct(string $name = "DefaultName", int $attack = 15, int $defence = 5, int $health = 150, int $extraAttack = 10) {
        parent::__construct($name, $attack, $defence, $health);
        $this->extraAttack = $extraAttack;
    }

    public function doAttack(Unit $target) {
        $targetPoints = $target->health + $target->defence;
        $selfPoints = $this->attack + $this->extraAttack;

        $target->setHealth($targetPoints - $selfPoints);
    }
}

class Item {
    public string $name;
    public int $attack;
    public int $defence;
    public int $health;

    public function __construct(string $name = "DefaultName", int $attack = 0, int $defence = 0, int $health = 0) {
        $this->name = $name;
        $this->attack = $attack;
        $this->defence = $defence;
        $this->health = $health;
    }
}

$max = new Warrior("Max");
$den = new Unit("Den");
$armor = new Item("Body armor", 5, 5, 15);
$den->equipItem($armor);

echo "<h1>Before</h1>";
echo "<h2>{$max->name}</h2><p><b>Health: </b>{$max->health}</p><p><b>Attack: </b>{$max->attack}</p><p><b>Defence: </b>{$max->defence}</p>";
echo "<h2>{$den->name}</h2><p><b>Health: </b>{$den->health}</p><p><b>Attack: </b>{$den->attack}</p><p><b>Defence: </b>{$den->defence}</p>";

function battle(Unit $unitOne, Unit $unitTwo) {

    $startUnit = $unitOne->health > $unitTwo->health ? $unitOne : $unitTwo;

    $endUnit = $startUnit === $unitOne ? $unitTwo : $unitOne;

    while ($startUnit->health >= 0 && $endUnit->health >= 0) {
        $startUnit->doAttack($endUnit);
        $endUnit->doAttack($startUnit);
    }

    $winUnit = $startUnit->health > 0 ? $startUnit : $endUnit;

    return $winUnit->name;
}

echo "<hr>" . battle($max, $den) . " Win!<hr>";

echo "<h1>After</h1>";
echo "<h1>{$max->name}</h1><p><b>Health: </b>{$max->health}</p>";
echo "<h1>{$den->name}</h1><p><b>Health: </b>{$den->health}</p>";