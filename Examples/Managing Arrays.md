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

### Constructing an Extended Arrays array

Each array implementation in Extended Arrays is handled as a PHP object. These objects are constructed using a standard PHP array. 

#### Example:
```php
$array = new \ExtendedArrays\AssociativeArray (
    [
        'name' => 'nathan'
    ]
);
```

However, there are other ways you can construct them that allows you to have more control over how your array is used. These are documented in [Associative Arrays](https://github.com/nathan-fiscaletti/extended-arrays/blob/master/Examples/Associative%20Arrays.md) and [Indexed Arrays](https://github.com/nathan-fiscaletti/extended-arrays/blob/master/Examples/Indexed%20Arrays.md) respectively. 

### Accessing Array Elements

There are three ways in which you can access array elements of Extended Array arrays.

#### 1. ArrayAccess
```php
// Set
$array['key'] = 'value';

// Get
$value = $array['key'];
``` 

#### 2. Property Access
```php
// Set
$array->key = 'value';

// Get
$value = $array->key;

// Note: If you are using an IndexedArray
// you must prefix the property with an underscore.

// Set
$idx->_0 = 'value';

// Get
$value = $idx->_0;
``` 

#### 3. Function Calls
```php
// Set
$array->key('value');

// Get
$value = $array->key();

// Note: If you are using an IndexedArray
// you must prefix the function with an underscore.

// Set
$idx->_0('value');

// Get
$value = $idx->_0();
``` 

### Controlling `_asStdArray()`

Each Extended Arrays array that uses the [BaseArray](https://github.com/nathan-fiscaletti/extended-arrays/blob/master/src/ExtendedArrays/Traits/BaseArray.php) trait implements the `_asStdArray()` function. This function will return a standard PHP array representing the Extended Arrays array.

You can control which values are returned in this by setting the `$hidden` property of your Extended Array array implementation.

There are two ways to do this:

#### 1. Inline Example
```php
// Create a new array using a custom class
// that extends AssociaitveArray and override
// it's $hidden property. 
//
// Since we are doing this inline, we have to
// override the constructor as well.
$arr = new class extends \ExtendedArrays\AssociativeArray {

    // These keys will not be returned
    // when _asStdArray() is called.
    protected $hidden = [
        'name'
    ];

    // Override the constructor
    // to apply our standard php
    // array to the class.
    public function __construct()
    {
        parent::__construct (
            [
                'name' => 'nathan',
                'age' => 22
            ]
        );
    }

};

// Output the standard PHP array representation
// of our class filtered using $hidden.
print_r($arr->_asStdArray());
```

#### Output: 
    Array
    (
        [age] => 22
    )

#### 2. Extendeding Extended Arrays Example
```php
// Create a new class that extends AssociativeArray
// and override it's `$hidden` property.
class NameHiddenArray extends \ExtendedArrays\AssociativeArray
{
    protected $hidden = [
        'name'
    ];
}

// Create a new instance of the NameHiddenArray class
// and initialize it with our standard PHP array.
$arr = new NameHiddenArray([
    'name' => 'nathan',
    'age' => 22
]);

// Output the standard PHP array representation
// of our class filtered using $hidden.
print_r($arr->_asStdArray());
```

#### Output: 
    Array
    (
        [age] => 22
    )