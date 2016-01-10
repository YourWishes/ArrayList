<?php
/*
 * Merging lists together.
 */

//Import ArrayList lib
require('ArrayList.php');

class TestClass {
    public $data;
    public function __construct($data) {$this->data = $data;}
    public function getData() {return $this->data;}
}

//Create the lists
$list1 = new ArrayList('TestClass');
$list2 = new ArrayList('TestClass');

//Create our Objects
$objectA = new TestClass('Object A');
$objectB = new TestClass('Object B');
$objectC = new TestClass('Object C');
$objectD = new TestClass('Object D');
$objectE = new TestClass('Object E');
$objectF = new TestClass('Object F');

$list1->add($objectA);
$list1->add($objectB);
$list1->add($objectC);

$list2->add($objectD);
$list2->add($objectE);
$list2->add($objectF);
$list2->add($objectA);//ObjectA is in both List1 and List2

$listMerged = new ArrayList('TestClass');
$listMerged->add($list1);
$listMerged->add($list2);

echo "List: " . strval($listMerged);//Prints [{data: "Object A"}, {data: "Object B"}, {data: "Object C"}, {data: "Object D"}, {data: "Object E"}, {data: "Object F"}]

//Merging Lists with various Types
class ClassA {}
class ClassB {}
class ClassC {}

$objectA = new ClassA();
$objectB = new ClassB();
$objectB2 = new ClassB();
$objectC = new ClassC();

$listA = new ArrayList('ClassA|ClassB');
$listB = new ArrayList('ClassB|ClassC');

$listA->add($objectA);
$listA->add($objectB);
$listB->add($objectB2);
$listB->add($objectC);

//ListA will now Contain $objectA, $objectB and $objectB2, but not $objectC, because it is not in the allowed classes.