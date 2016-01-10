<?php
/*
 * Searching through various Lists
 */

//Import ArrayList lib
require('ArrayList.php');

class TestClass {
    private $data;
    public function __construct($data) {$this->data = $data;}
    public function getData() {return $this->data;}
}

//Create the list
$list = new ArrayList('TestClass');

//Create our Objects
$x = new TestClass(10);
$list->add($x);

$x = new TestClass(9);
$list->add($x);

$x = new TestClass(12);
$list->add($x);

$x = new TestClass(18);
$list->add($x);

$x = new TestClass(45);
$list->add($x);

$x = new TestClass(90);//This is the object we want to find in the list.
$list->add($x);

$x = new TestClass(1);
$list->add($x);

$x = new TestClass(69);
$list->add($x);

$x = new TestClass(420);
$list->add($x);

$x = new TestClass(1337);
$list->add($x);

//Now try and find the object with the value we want
$object = $list->getByFunctionVale('getData', 90);
echo 'Found Object ' . $object->getData();//Prints 90



//Using Strict Comparison (For Object based searching)
//Create the list
$list = new ArrayList('TestClass');

$sub_objectA = new TestClass('Whatever Sub Object A');
$sub_objectB = new TestClass('Whatever Sub Object B');
$sub_objectC = new TestClass('Whatever Sub Object C');

//Create our Objects
$x = new TestClass($sub_objectA);
$list->add($x);

$x = new TestClass($sub_objectB);//We want to find this.
$list->add($x);

$x = new TestClass($sub_objectC);
$list->add($x);

$object = $list->getByFunctionVale('getData', $sub_objectB);
echo 'Found Object ' . $object->getData()->getData();//Prints "Whatever Sub Object B"