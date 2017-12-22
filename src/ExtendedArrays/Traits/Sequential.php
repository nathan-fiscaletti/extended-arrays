<?php

namespace ExtendedArrays\Traits;

/**
 * The sequential trait can only be applied to IndexedArray.
 */
trait Sequential {
    /**
     * Override the constructor of the IndexedArray to
     * enforce a sequential array.
     *
     * @param array $args
     */
    public function __construct(array $args = [])
    {
        if (! is_subclass_of($this, '\ExtendedArrays\IndexedArray')) {
            throw new \Exception('Cannot apply \'Sequential\' trait to a class that does not inherit \\ExtendedArrays\\IndexedArray');
        }

        $keys = array_keys($args);
        $lastKey = -1;
        foreach ($keys as $key) {
            if (! is_int($key) || $key != $lastKey + 1) {
                throw new \Exception('All keys used to construct an IndexedArray that inherits the \'Sequential\' trait must be integral and sequential.');
            }
            $lastKey+=1;
        }
        $this->_args = $args;
    }

    /**
     * Override the offsetSet function of the IndexedArray
     * to force modification of in sequential bounds offsets.
     *
     * @param  mixed $offset
     * @param  mixed $value
     */
    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->_args[sizeof($this->_args)] = $value;
        } else {
            if (is_int($offset)) {
                if ($offset <= sizeof($this->_args)) {
                    $this->_args[$offset] = $value;
                } else {
                    throw new \Exception('Cannot modify offset \''.$offset.'\' of IndexedArray. Outside of sequential bounds.');    
                }
            } else {
                throw new \Exception('Cannot modify offset \''.$offset.'\' of IndexedArray.');
            }
        }
    }
}