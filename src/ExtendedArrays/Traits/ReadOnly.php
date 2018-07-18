<?php

namespace ExtendedArrays\Traits;

use ExtendedArrays\AssociativeArray;

/**
 * This trait can be only be applied to associative arrays.
 */
trait ReadOnly
{
    /**
     * Construct the object and verify that this trait is being
     * applied to an instance of AssociativeArray.
     * @param array $args
     *
     * @throws \Exception
     */
    public function __construct(array $args = [])
    {
        if (! is_subclass_of($this, '\ExtendedArrays\AssociativeArray')) {
            throw new \Exception('Cannot apply \'ReadOnly\' trait to a class that does not inherit \\ExtendedArrays\\AssociativeArray');
        }

        parent::__construct($args);
    }

    /**
     * Unset an offset in the array.
     *
     * @param  mixed $offset
     * @throws \Exception
     */
    public function offsetUnset($offset)
    {
        throw new \Exception('Cannot modify a read only array.');
    }

    /**
     * Override the offsetSet function to modify
     * values of the wrapped array.
     *
     * @param  mixed $offset
     * @param  mixed $value
     *
     * @throws \Exception
     */
    public function offsetSet($offset, $value)
    {
        throw new \Exception('Cannot modify a read only array.');
    }

    /**
     * Override the property setter function
     * to modify values of the wrapped array.
     *
     * @param string $key
     * @param mixed $val
     *
     * @throws \Exception
     */
    public function __set($key, $val)
    {
        throw new \Exception('Cannot modify a read only array.');
    }

    /**
     * Override the undefined function call handler
     * to modify or return values from the wrapped array.
     *
     * @param  string $name
     * @param  array  $arguments
     *
     * @return mixed
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        $ret = $this;

        if (count($arguments) < 1) {
            if (array_key_exists($name, $this->_args)) {
                if (is_array($this->_args[$name])) {
                    $ret = new AssociativeArray($this->_args[$name]);
                } else {
                    $ret = $this->_args[$name];
                }
            } else {
                throw new \Exception('Call to undefined function \''.$name.'\'.');
            }
        } else {
            throw new \Exception('Cannot modify a read only array.');
        }

        return $ret;
    }
}
