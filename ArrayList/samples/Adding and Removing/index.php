<?php
/*
 * Creating an ArrayList and assinging, then removing certain objects.
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

//Print the list as-is
echo "List 1:\n" . strval($myList) . "\n\n";
//Will Print: [{"name": "Hello"}, {"name": "World"}, {"name": "How"}, {"name": "Are"}, {"name": "You"}]

$myList->remove($object2);
echo "List 2:\n" . strval($myList) . "\n\n";
//Will Print: [{"name": "Hello"}, {"name": "How"}, {"name": "Are"}, {"name": "You"}]

$myList->remove($object3);
$myList->remove($object4);
$myList->remove($object5);
$myList->add($object2);
echo "List 3:\n" . strval($myList) . "\n\n";
//Will Print: [{"name": "Hello"}, {"name": "World"}]