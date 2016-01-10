<?php
/*
 * Restricting an ArrayList to certain types of Objects only
 */

//Import ArrayList lib
require('ArrayList.php');

//Our Classes
class ClassA {
    private $name;
    public function __construct($name) {$this->name = $name;}
}

class ClassB {
    private $name;
    public function __construct($name) {$this->name = $name;}
}

class ClassC extends ClassA {
    private $description;
    
    public function __construct($name, $description) {
        parent::__construct($name);
    }
}

//Create our Objects
$objectA1 = new ClassA('1');
$objectA2 = new ClassA('2');
$objectB1 = new ClassB('1');
$objectB2 = new ClassB('2');
$objectC1 = new ClassC('1', 'Some Description');
$objectC2 = new ClassC('2', 'Some Other Desc');


//Create a List for holding ClassB
$listB = new ArrayList('ClassB');
$listB->add($objectB1);//OK
$listB->add($objectB2);//OK
$listB->add($objectA1);//Throws Exception
$listB->add($objectC1);//Throws Exception

//Create a List for holding ClassA
$listA = new ArrayList('ClassA');
$listA->add($objectA1);//OK
$listA->add($objectA2);//OK
$listA->add($objectC1);//OK (Because ClassC extends ClassA)
$listA->add($objectB1);//Throws Exception

//Create a List for holding ClassC
$listC = new ArrayList('ClassC');
$listC->add($objectC1);//OK
$listC->add($objectC2);//OK
$listC->add($objectA1);//Throws Exception
$listC->add($objectB1);//Throws Exception

//Create a List for holding ClassC and ClassB
$listBC = new ArrayList('ClassB|ClassC');
$listBC->add($objectC1);//OK
$listBC->add($objectB1);//OK
$listBC->add($objectA1);//Throws Exception

//Create a list without boundaries
$listABC = new ArrayList();
$listABC->add($objectA1);//OK
$listABC->add($objectB1);//OK
$listABC->add($objectC1);//OK
$listABC->add('Something Else Entirely');//OK