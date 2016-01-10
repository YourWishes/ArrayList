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
