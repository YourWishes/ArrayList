<?php
/*
 * Creating an ArrayList and iterating over it in different ways.
 */

//Import ArrayList lib
require('ArrayList.php');

//Create our class
class MyClass {
    public $name;
    
    public function __construct($name) {
        $this->name = $name;
    }
}

//Create our Objects
$object1 = new MyClass('Hello');
$object2 = new MyClass('World');
$object3 = new MyClass('How');
$object4 = new MyClass('Are');
$object5 = new MyClass('You');

//Create our ArrayList
$myList = new ArrayList();

$myList->add($object1);
$myList->add($object2);
$myList->add($object3);
$myList->add($object4);
$myList->add($object5);

//Create our loop
for($i = 0; $i < $myList->size(); $i++) {
    echo $myList[$i]->name . " ";
}
//Will Print: "Hello World How Are You "

foreach($myList as $obj) {
    echo $obj->name . " ";
}
//Will Print: "Hello World How Are You "