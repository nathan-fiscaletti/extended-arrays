<?php

namespace ExtendedArrays\Tests;

use ExtendedArrays\IndexedArray as IdxArr;
use ExtendedArrays\AssociativeArray as AssocArr;

use PHPUnit\Framework\TestCase;

/**
 * @covers \ExtendedArrays\IndexedArray
 */
final class IndexedArrayTest extends TestCase {
    public function testConstructionMustBeIntegral() {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('All keys in an IndexedArray must be integral.');

        new IdxArr([
            'name' => 'nathan'
        ]);
    }

    public function testCanSetWithArrayAccess() {
        $arr = new IdxArr();
        $arr[0] = 'nathan';

        $this->assertEquals(
            'nathan',
            $arr[0]
        );
    }

    public function testCanSetWithProperties() {
        $arr = new IdxArr();
        $arr->_0 = 'nathan';

        $this->assertEquals(
            'nathan',
            $arr[0]
        );   
    }

    public function testCanSetWithFunctions() {
        $arr = new IdxArr();
        $arr->_0('nathan');

        $this->assertEquals(
            'nathan',
            $arr[0]
        );   
    }

    public function testCanGetWithArrayAccess() {
        $arr = new IdxArr(
            [
                'nathan'
            ]
        );

        $this->assertEquals(
            'nathan',
            $arr[0]
        );   
    }

    public function testCanGetWithProperties() {
        $arr = new IdxArr(
            [
                'nathan'
            ]
        );

        $this->assertEquals(
            'nathan',
            $arr->_0
        );   
    }

    public function testCanGetWithFunctions() {
        $arr = new IdxArr(
            [
                'nathan'
            ]
        );

        $this->assertEquals(
            'nathan',
            $arr->_0()
        );   
    }

    public function testGetArrayReturnedAsAssociativeArray() {
        $assoc = new IdxArr([
            [
                'name'
            ]
        ]);

        $this->assertInstanceOf(AssocArr::class, $assoc->_0());
    }

    public function testCallArrayReturnedAsAssociativeArray() {
        $assoc = new IdxArr([
            [
                'name'
            ]
        ]);

        $this->assertInstanceOf(AssocArr::class, $assoc->_0);
    }

    public function testGetWithFunctionResultsInUndefinedIndex() {
        $arr = new IdxArr();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Undefined offset \'0\'.');

        $something = $arr->_0();
    }

    public function testGetWithPropertyResultsInUndefinedIndex() {
        $arr = new IdxArr();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Undefined offset \'0\'.');

        $something = $arr->_0;
    }

    public function testGetWithArrayAccessResultsInUndefinedIndex() {
        $arr = new IdxArr();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Undefined offset \'0\'.');

        $something = $arr[0];
    }

    public function testCannotSetAssocKeys() {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Cannot set offset \'name\' of IndexedArray.');

        $arr = new IdxArr();
        $arr['name'] = 'nathan';
    }


}