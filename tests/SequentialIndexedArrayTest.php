<?php

namespace ExtendedArrays\Tests;

use ExtendedArrays\SequentialIndexedArray as SeqIdxArr;

use PHPUnit\Framework\TestCase;

/**
 * @covers \ExtendedArrays\SequentialIndexedArray
 */
final class SequentialIndexedArrayTest extends TestCase {
    public function testConstructionMustUseSequentialArray() {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('All keys used to construct an IndexedArray that inherits the \'Sequential\' trait must be integral and sequential.');

        new SeqIdxArr([
            0 => 'test',
            1 => 'test',
            3 => 'something'
        ]);
    }

    public function testConstructionMustUseSequentialArrayStartingWithZero() {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('All keys used to construct an IndexedArray that inherits the \'Sequential\' trait must be integral and sequential.');

        new SeqIdxArr([
            1 => 'test',
            2 => 'test2',
            3 => 'something'
        ]);
    }

    public function testModifyOffsetOutsideSequentialBoundsResultsInException() {
        $arr = new SeqIdxArr([
            0 => 'a',
            1 => 'b',
            2 => 'c'
        ]);

        $arr->_1 = 'd';

        $this->assertEquals(
            'd',
            $arr->_1
        );

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Cannot modify offset \'4\' of IndexedArray. Outside of sequential bounds.');

        $arr->_4('e');
    }
}
