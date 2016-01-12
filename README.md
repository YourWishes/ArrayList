# ArrayList
Java/C# Like Array Lists for PHP.

## What are ArrayLists?
ArrayLists are managed arrays for PHP, based on the design of Java/C# Lists. ArrayLists allow for easy Object adding and removing from arrays without worring about pushing and splicing arrays over and over.

Other useful features are always getting added to the class, such as Filtering, getting by sub object values, restricting allowed classes of the array, etc.

## Sounds easy enough, but how?
I suggest you start by looking at the /ArrayLists/samples/ folder for a basic guide, starting with the "Adding and Removing" file.

The basic workflow is the following:
```
$myObject = new WhateverClass();
$myList = new ArrayList('WhateverClass');
$myList->add($myObject);
```
And it's as simple as that, you can add and remove items from the list to your hearts content, and do some pretty nifty stuff with them as well.

## You mentioned other features?
Yes, you can do a lot of cool stuff with ArrayLists, from basic iteration
```
$list = new ArrayList();
foreach($list as $item) {}
```

To Complex filtering
```
$list = new ArrayList();
$list->filter('getVersion', 1.00);
```

## I'm in! What do I need to do?
To get started, download the ArrayList.php class file and put it in your project somewhere. Then simply require it as you would any other PHP file.

And your set! It's that easy.


# Known Bugs
At this stage I only know of one bug, very minor for those used to the Java way of iterating over lists.

Unlike Java there is no way of checking if an array is being currently iterated over, there is a 'sort of hacky' way of doing it, however it would result in more exceptions than necessary.

What does this mean? Well it means that ConcurrentModificationExceptions cannot be handled properly, and should be treated with care.

### How to replicate:
```
$obj1 = new MyClass('Something');
$obj2 = new MyClass('Something Else');

$myArr = new ArrayList('MyClass');
$myArr->add($obj1);
$myArr->add($obj2);

//...

foreach($myArr as $obj) {
    if($obj->getData() == 'Something') $myArr->remove($obj);
}
```
Will cause the iteration to only occur once, since the first object is iterated, removed, and the second object becomes the first object, so no second object is ever iterated over.

### How to fix:
```
//...
foreach($myArr->createCopy() as $obj) {
    if($obj->getData() == 'Something') $myArr->remove($obj);
}
```
Since the array is duplicated before being iterated over, the cloned and iterated array is never actually modified.
