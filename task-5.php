<?php

class A {
    public function foo() {
        static $x = 0;
        echo ++$x;
    }
}

$a1 = new A();  //переменной присвоен экземпляр класса
$a2 = new A();  //переменной присвоен экземпляр класса
$a1->foo();     //вызов метода класса, х = 0, перед выводом происходит инкремент переменной, поэтому на экран выводится значение - 1
$a2->foo();     //снова инкремент переменной перед выводом на экран - 2
$a1->foo();     // - 3
$a2->foo();     // - 4