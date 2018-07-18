<?php

namespace ExtendedArrays;

use ExtendedArrays\Traits\BaseArray;

/**
 * An associative array.
 */
class AssociativeArray implements \ArrayAccess
{
    use BaseArray;

    /**
     * Create the associative array.
     *
     * @param array $args
     */
    public function __construct(array $args = [])
    {
        $this->_args = $args;
    }

    /**
     * Override the offsetSet function to modify
     * values of the wrapped array. Key is enforced.
     *
     * @param  mixed $offset
     * @param  mixed $value
     *
     * @return mixed
     * @throws \Exception
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            throw new \Exception('Must supply key to modify arguments in an AssociativeArray.');
        } else {
            $this->_args[$offset] = $value;
        }
    }

    /**
     * Override the property retrieval function
     * to return values from the wrapped array.
     *
     * @param  string $key
     *
     * @return mixed
     * @throws \Exception
     */
    public function __get($key)
    {
        if (array_key_exists($key, $this->_args)) {
            if (is_array($this->_args[$key])) {
                return new AssociativeArray($this->_args[$key]);
            } else {
                return $this->_args[$key];
            }
        } else {
            throw new \Exception('Undefined property \''.$key.'\'.');
        }
    }

    /**
     * Override the property setter function
     * to modify values of the wrapped array.
     *
     * @param string $key
     * @param mixed $val
     */
    public function __set($key, $val)
    {
        $this->_args[$key] = $val;
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
            $this->_args[$name] = $arguments[0];
        }

        return $ret;
    }
}
