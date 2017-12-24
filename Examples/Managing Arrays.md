----


### Managing Arrays

#### The BaseArray trait

Each array in Extended Arrays uses the [BaseArray](https://github.com/nathan-fiscaletti/extended-arrays/blob/master/src/ExtendedArrays/Traits/BaseArray.php) trait. This trait implements some of the [ArrayAccess](http://php.net/manual/en/class.arrayaccess.php) functions that are standard across all of Extended Arrays array implementations, and leaves the rest up to the higher level implementation. This trait also adds the `_asStdArray()` function that will convert any Extended Arrays array back to a standard PHP array.

##### Example:
```php
$array = new \ExtendedArrays\AssociativeArray (
    [
        'name' => 'nathan',
        'age' => 22,
        0 => 5
    ]
);    

print_r($array->_asStdArray());
```

##### Output:
    Array
    (
        [name] => nathan
        [age] => 22
        [0] => 5
    )