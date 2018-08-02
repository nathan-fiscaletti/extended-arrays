<?php

namespace ExtendedArrays\Tests;

use ExtendedArrays\Traits\BaseArray;

use ExtendedArrays\AssociativeArray as AssocArr;

use PHPUnit\Framework\TestCase;

/**
 * @covers \ExtendedArrays\Traits\BaseArray
 */
final class BaseArrayTraitTest extends TestCase {
    public function testOffsetExists() {
        $assoc = new class extends \stdClass {
            use BaseArray;

            public function __construct()
            {
                $this->_args = [
                    'name' => 'nathan'
                ];
            }

        };

        $this->assertTrue($assoc->offsetExists('name'));
        $this->assertFalse($assoc->offsetExists('invalid_key'));
    }

    public function testOffsetUnset() {
        $assoc = new class extends \stdClass {
            use BaseArray;

            public function __construct()
            {
                $this->_args = [
                    'name' => 'nathan'
                ];
            }

        };
        $assoc->offsetUnset($assoc->offsetGet('name'));

        $this->assertNotContains('name', $assoc->_asStdArray());
    }

    public function testOffsetGetOnOffsetArray() {
        $assoc = new class extends \stdClass {
            use BaseArray;

            public function __construct()
            {
                $this->_args = [
                    'name' => ['nathan', 'peter']
                ];
            }

        };
        $result = $assoc->offsetGet('name');

        $this->assertInstanceOf(AssocArr::class, $result);
    }

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
