<?php

namespace ExtendedArrays\Tests;

use ExtendedArrays\Traits\BaseArray;

use PHPUnit\Framework\TestCase;

/**
 * @covers \ExtendedArrays\Traits\BaseArray
 */
final class BaseArrayTraitTest extends TestCase {
    public function testAsStdArrayReturnsArray() {
        $assoc = new class extends \stdClass {
            use BaseArray;

            public function __construct()
            {
                $this->_args = [
                    'name' => 'nathan'
                ];
            }

        };

        $this->assertInternalType('array', $assoc->_asStdArray());
    }

    public function testAsStdArrayWithHiddenPropertyHidesOffsets() {
        $assoc = new class extends \stdClass {
            use BaseArray;

            public $hidden = [
                'name'
            ];

            public function __construct()
            {
                $this->_args = [
                    'name' => 'nathan',
                    'age' => 22
                ];
            }
        };

        $this->assertNotContains('name', array_keys($assoc->_asStdArray()));
    }

    public function testCallToNonExistantArrayOffsetResultsInNull() {
        $arr = new class implements \ArrayAccess {
            use BaseArray;

            public function offsetSet($offset, $value) {
                // We have to declare this since the BaseArray trait does not.
            }

            public function __construct() {
                $this->_args = [
                    'name' => 'nathan'
                ];
            }
        };

        $something = $arr['name'];

        $this->assertEquals(
            $something,
            'nathan'
        );

        $something = $arr['test'];

        $this->assertEquals(
            $something,
            null
        );
    }
}