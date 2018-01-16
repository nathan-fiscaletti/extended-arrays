<?php

namespace ExtendedArrays\Tests;

use ExtendedArrays\Traits\Sequential;

use PHPUnit\Framework\TestCase;

/**
 * @covers \ExtendedArrays\Traits\Sequential
 */
final class SequentialTraitTest extends TestCase {
    public function testInheritsIndexedArray() {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Cannot apply \'Sequential\' trait to a class that does not inherit \ExtendedArrays\IndexedArray');

        $obj = new class {
            use Sequential;
        };
    }
}