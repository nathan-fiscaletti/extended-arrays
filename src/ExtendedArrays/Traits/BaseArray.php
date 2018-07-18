<?php

namespace ExtendedArrays\Traits;

use ExtendedArrays\AssociativeArray;

/**
 * This class is used as a base for the AssociativeArray and IndexedArray.
 */
trait BaseArray
{
    /**
     * The wrapped array object for storing data.
     *
     * @var array
     */
    protected $_args = [];

    /**
     * Check if an offset exists in the array.
     *
     * @param  mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->_args);
    }

    /**
     * Unset an offset in the array.
     *
     * @param  mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->_args[$offset]);
    }

    /**
     * Retrieve a value based on an offset in the array.
     *
     * @param  mixed $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->_args[$offset])
            ? (
                (is_array($this->_args[$offset]))
                    ? new AssociativeArray($this->_args[$offset])
                    : $this->_args[$offset]
            ) : null;
    }

    /**
     * Convert the array to a standard PHP array using
     * the $hidden property as a mask.
     *
     * @return array
     */
    public function _asStdArray()
    {
        if (
            property_exists($this, 'hidden') &&
            is_array($this->hidden)
        ) {
            $results = [];

            foreach ($this->_args as $key => $value) {
                if (! in_array($key, $this->hidden)) {
                    $results[$key] = $value;
                }
            }

            return $results;
        } else {
            return $this->_args;
        }
    }
}
