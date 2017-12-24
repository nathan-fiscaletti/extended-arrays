## Index:
* [Managing Arrays](https://github.com/nathan-fiscaletti/parameterparser/blob/master/examples/Managing%20Arrays.md)
* [Associative Arrays](https://github.com/nathan-fiscaletti/parameterparser/blob/master/examples/Associative%20Arrays.md)
* Indexed Arrays

----
### Indexed Arrays

Associaitive Arrays are a data structure consisting of a collection of elements (values or variables), each identified by at least one array index or key.

#### Creating an Indexed Array with Extended Arrays

Indexed arrays require their base array to only house integral indexes. 

##### Example
```php

// This would work
$arr = new \ExtendedArrays\IndexedArray ([
    0 => 'nathan',
    1 => 'is',
    2 => 'schwifty'
]);

// These would throw an exception
// since 'name' is not integral.
$arr['name'] = 'nathan';
$arr->name = 'nathan';
$arr->name('nathan');

// This would throw an exception since 
// it's base array house non-integral 
// keys in it's KeyList.
$arr = new \ExtendedArrays\IndexedArray ([
    0 => 'nathan',
    1 => 'is',
    2 => 'schwifty',
    'age' => 22
]);

```

#### Enforcing Sequential Array keys

One of the features of Extended Arrays is to enforce sequential integers as the keys that an array can house when using Indexed Arrays. This means that during construction of the array and when editing it, you can only modify or set the keys that are in seqential order. 

*Only indexed arrays can enforce sequence.*

##### Example
```php
// This would work
$arr = new \ExtendedArrays\SequentialIndexedArray ([
    0 => 'nathan',
    1 => 'is',
    2 => 'schwifty'
]);
$arr->_3 = 'nice';

// These would throw an exception
// since index '5' does not come after
// index '3'.
$arr[5] = 'nathan';
$arr->_5 = 'nathan';
$arr->_5('nathan');

// This would throw an exception
// since 'name' is not integral
// nor sequential.
$arr['name'] = 'nathan';
$arr->name = 'nathan';
$arr->name('nathan');

// This would throw an exception
// since the base array for the
// indexed array is not Sequential.
$arr = new \ExtendedArrays\SequentialIndexedArray ([
    0 => 'nathan',
    4 => 'is',
    5 => 'schwifty'
]);
```