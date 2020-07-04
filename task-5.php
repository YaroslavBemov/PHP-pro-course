<?php

class A {
    public function foo() {
        static $x = 0;
        echo ++$x;
    }
}

class B extends A {
}

$a1 = new A();  //переменной присвоен экземпляр класса
$b1 = new B();  //переменной присвоен экземпляр класса
$a1->foo();     // - 1, инкремент переменной и вывод на экран из объекта a1
$b1->foo();     // - 1, инкремент переменной и вывод на экран из объекта b1
$a1->foo();     // - 2, еще раз инкремент переменной и вывод на экран из объекта а1
$b1->foo();     // - 2, еще раз инкремент переменной и вывод на экран из объекта b1