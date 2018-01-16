## Extended Arrays Documentation

#### Index:
* [Managing Arrays](https://github.com/nathan-fiscaletti/extended-arrays/blob/master/Examples/Managing%20Arrays.md)
* Associative Arrays
* [Indexed Arrays](https://github.com/nathan-fiscaletti/extended-arrays/blob/master/Examples/Indexed%20Arrays.md)

----
### Associative Arrays

Associaitive Arrays are an abstract data type composed of a collection of (key, value) pairs, such that each possible key appears at most once in the collection. With associaitive arrays, you can use any object type as the key for the (key, value) pair. 

#### Creating an Associative Array with Extended Arrays

```php
// Create the associative array
$array = new \ExtendedArrays\AssociativeArray (
    [
        'name' => 'nathan',
        'age' => 22
        0 => 5
    ]
);
```

#### Enforcing Associative Array keys

One of the features of Extended Arrays is to enforce the keys that an array can access. This means that during construction of the array and when editing it, you can only modify or set the keys defined in the arrays `$fillable` property.

*You can only use `$fillable` on RestrictedAssociativeArray implementations.*

##### Example:
```php

// First we need to define our class that extends
// AssociativeArray and set a `$fillable` filter 
// in it's class properties.
final class MyArray extends \ExtendedArrays\RestrictedAssociativeArray {
    protected $fillable = [
        'name',
        'age'
    ];
}

// This would work
$arr = new MyArray([
    'name' => 'nathan'
]);
$arr->age = 22;

// These would throw an exception
// since 'height' is not in the
// filter of fillable keys.
$arr['height'] = 72;
$arr->height = 72;
$arr->height(72);

// This would throw an exception
// since 'height' is not in the 
// filter of fillable keys.
$arr = new MyArr([
    'name' => 'nathan',
    'height' => 72
]);
```

#### ReadOnly Associative Arrays

You can create a ReadOnly AssociativeArray, either of the Restricted model or normal. When you create a ReadOnly array, only the values set during the constrsuction of the object will be available. You will not be able to add or modify values or keys.

```php
$array = new \ExtendedArrays\ReadOnlyAssociativeArray (
    [
        'name' => 'nathan',
        'age' => 22
        'hair' => 'brown'
    ]
);

// This will work
$age = $array->age;
$name = $array['name'];
$hair = $array->hair();

// These will throw exceptions
$array->age = 10;
$array['name'] = 'test';
$array->hair('yellow');
```

#### Limitations

1. When adding a key to an Associative Array, you cannot use the `$array[] = x` method as keys will not be assumed. A key **must** be provided for the (Key, Value) pair. `$array['mykey'] = x`.
