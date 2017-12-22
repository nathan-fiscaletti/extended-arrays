<?php

namespace ExtendedArrays\Traits;

/**
 * This trait can only be applied to AssociativeArray
 */
trait Restricted {

    /**
     * Override the constructor for AssociativeARray
     * to enforce the list of restricted keys.
     *
     * @param array $args
     * @throws \Exception
     */
    public function __construct(array $args = [])
    {
        if (! is_subclass_of($this, '\ExtendedArrays\AssociativeArray')) {
            throw new \Exception('Cannot apply \'Restricted\' trait to a class that does not inherit \\ExtendedArrays\\AssociativeArray');
        }

        if (! property_exists($this, 'fillable')) {
            throw new \Exception('Cannot apply \'Restricted\' trait to a class that does not inherit the \'$fillable\' class property.');
        }

        foreach ($this->fillable as $key) {
            $this->_args[$key] = null;
        }

        $keys = array_keys($args);
        for($i=0;$i<sizeof($args);$i++)
        {
            if (in_array($keys[$i], $this->fillable)) {
                $this[$keys[$i]] = $args[$keys[$i]];
            } else {
                throw new \Exception('Cannot initialize element \''.$keys[$i].'\' on an AssociativeArray that uses the Restricted trait. \''.$keys[$i].'\' is not fillable.');
            }
        }
    }

    /**
     * Override the offsetSet function to enforce
     * the list of restricted keys.
     *
     * @param  mixed $offset
     * @param  mixed $value
     * @throws \Exception
     */
    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            throw new \Exception('Must supply key to modify an associative array.');
        } else {
            if ($this->_isFillable($offset)) {
                $this->_args[$offset] = $value;
            } else {
                throw new \Exception('Cannot modify element \''.$offset.'\'. Not fillable.');
            }
        }
    }

    /**
     * Override the offsetExists function to enforce
     * the list of restricted keys.
     * 
     * @param  mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset) {
        return $this->_isFillable($offset);
    }

    /**
     * Override the offsetUnset function to disable it
     * as restricted traits enforce array keys.
     *
     * @param  mixed $offset
     * @throws \Exception 
     */
    public function offsetUnset($offset) {
        throw new \Exception('Unset not supported in a class using the Restricted trait.');
    }

    /**
     * Override the offsetGet function to enforce
     * the list of restricted keys.
     *
     * @param  mixed $offset
     */
    public function offsetGet($offset) {
        return isset($this->_args[$offset]) ? $this->_args[$offset] : null;
    }

    /**
     * Override the property retrieval function
     * to enforce the list of restricted keys.
     *
     * @param  string $key
     *
     * @return mixed
     * @throws \Exception
     */
    public function __get($key) {
        if ($this->_isFillable($key)) {
            return $this->_args[$key];
        } else {
            throw new \Exception('Undefined property \''.$key.'\'.');
        }
    }

    /**
     * Override the property setter function
     * to enforce the list of restricted keys.
     *
     * @param string $key
     * @param mixed $val
     * @throws \Exception
     */
    public function __set($key, $val) {
        if ($this->_isFillable($key)) {
            $this->_args[$key] = $val;
        } else {
            throw new \Exception('Undefined property \''.$key.'\'.');
        }
    }

    /**
     * Override the undefined function call back 
     * and use it to set and get array values.
     *
     * @param  string $name
     * @param  array  $arguments [description]
     * 
     * @return mixed
     * @throws \Exception
     */
    public function __call($name, $arguments) {
        $ret = $this;
        if ($this->_isFillable($name)) {
            if (count($arguments) < 1) {
                $ret = $this->_args[$name];
            } else {
                $this->_args[$name] = $arguments[0];
            }
        } else {
            throw new \Exception('Call to undefined function \''.$name.'\'.');
        }

        return $ret;
    }

    /**
     * Check if a key is fillable.
     *
     * @param  string  $key
     * 
     * @return bool
     */
    private function _isFillable($key)
    {
        return in_array($key, $this->fillable);
    }
}
