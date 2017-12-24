## Index:
* [Managing Arrays](https://github.com/nathan-fiscaletti/parameterparser/blob/master/examples/Managing%20Arrays.md)
* Associative Arrays
* [Indexed Arrays](https://github.com/nathan-fiscaletti/parameterparser/blob/master/examples/Indexed%20Arrays.md)

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

*You can only use `$fillable` on associative arrays.*

##### Example:
```php
class MyArray extends \ExtendedArrays\AssociativeArray {
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

// This would throw an exception
$arr = new MyArr([
    'name' => 'nathan',
    'height' => 72
]);

// This would throw an exception
$arr = new MyArr([
    'name' => 'nathan'
]);
$arr->height = 72;
```