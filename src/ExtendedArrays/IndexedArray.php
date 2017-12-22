<?php

namespace ExtendedArrays;

use ExtendedArrays\Traits\BaseArray;

/**
 * An Indexed array.
 */
class IndexedArray implements \ArrayAccess
{
    use BaseArray;

    /**
     * Override the constructor to enforce
     * integral indexed arrays only.
     *
     * @param array $args
     */
    public function __construct(array $args = [])
    {
        $keys = array_keys($args);
        foreach ($keys as $key) {
            if (! is_int($key)) {
                throw new \Exception('All keys in an IndexedArray must be integral.');
            }
        }
        $this->_args = $args;
    }

    /**
     * Override the offsetSet function to enforce
     * integral keys only.
     *
     * @param  mixed $offset
     * @param  mixed $value
     *
     * @throws \Exception
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->_args[count($this->_args)] = $value;
        } else {
            if (is_int($offset)) {
                $this->_args[$offset] = $value;
            } else {
                throw new \Exception('Cannot set offset \''.$offset.'\' of IndexedArray.');
            }
        }
    }

    /**
     * Override the offsetGet function to throw
     * an undefined offset error when a key is
     * not found.
     *
     * @param  mixed $offset
     *
     * @return mixed
     * @throws \Exception
     */
    public function offsetGet($offset)
    {
        if (isset($this->_args[$offset])) {
            return $this->_args[$offset];
        } else {
            throw new \Exception('Undefined offset \''.$offset.'\'.');
        }
    }

    /**
     * Override the property getting function
     * to check for prefixed integral key access.
     *
     * @param  string $key
     *
     * @return mixed
     * @throws \Exception
     */
    public function __get($key)
    {
        if (
            $this->isPrefixedKey($key)
        ) {
            if (array_key_exists($this->keyForPrefixedKey($key), $this->_args)) {
                $ret = $this->_args[$this->keyForPrefixedKey($key)];
            } else {
                throw new \Exception('Undefined offset \''.$this->keyForPrefixedKey($key).'\'.');
            }
        } else {
            throw new \Exception('Undefined property \''.$key.'\'.');
        }

        return $ret;
    }

    /**
     * Override the property setting function
     * to check for prefixed integral key access.
     *
     * @param string $key
     * @param mixed  $val
     *
     * @throws \Exception
     */
    public function __set($key, $val)
    {
        if (
            $this->isPrefixedKey($key)
        ) {
            $this->offsetSet($this->keyForPrefixedKey($key), $val);
        } else {
            throw new \Exception('Undefined property \''.$key.'\'.');
        }
    }

    /**
     * Override the undefined function handler to
     * enforce integral key usage.
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
        if (
            $this->isPrefixedKey($name)
        ) {
            if (count($arguments) < 1) {
                if (array_key_exists($this->keyForPrefixedKey($name), $this->_args)) {
                    $ret = $this->_args[$this->keyForPrefixedKey($name)];
                } else {
                    throw new \Exception('Undefined offset \''.$this->keyForPrefixedKey($name).'\'.');
                }
            } else {
                $this->offsetSet($this->keyForPrefixedKey($name), $arguments[0]);
            }
        } else {
            throw new \Exception('Call to undefined function \''.$name.'\'.');
        }

        return $ret;
    }

    /**
     * Retrieve a key based on a prefixed key string.
     *
     * @param  string $key
     *
     * @return int
     */
    private function keyForPrefixedKey($key)
    {
        return intval(substr($key, 1, strlen($key) - 1));
    }

    /**
     * Check if a string is in the proper format
     * to be a prefixed integral array key.
     *
     * @param  string  $key
     * @return bool
     */
    private function isPrefixedKey($key)
    {
        if (strlen($key) > 1) {
            if (substr($key, 0, 1) == '_') {
                try {
                    intval(substr($key, 1, strlen($key) - 1));

                    return true;
                } catch (\Exception $e) {
                    return false;
                }
            }
        }
    }
}
