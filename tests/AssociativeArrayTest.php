<?php

namespace ExtendedArrays\Tests;

use ExtendedArrays\AssociativeArray as AssocArr;

use PHPUnit\Framework\TestCase;

/**
 * @covers \ExtendedArrays\AssociativeArray
 */
final class AssociativeArrayTest extends TestCase {
    public function testCanBeCreatedFromValidArray() {
        $assoc = new AssocArr([
            'name' => 'nathan'
        ]);

        $this->assertEquals(
            $assoc['name'],
            'nathan'
        );

        return;
    }

    public function testCanSetUsingArrayAccess() {
        $assoc = new AssocArr();

        $assoc['name'] = 'nathan';

        $this->assertEquals(
            $assoc['name'],
            'nathan'
        );
    }

    public function testCanSetUsingClassProperties() {
        $assoc = new AssocArr();

        $assoc->name = 'nathan';

        $this->assertEquals(
            $assoc['name'],
            'nathan'
        );
    }

    public function testCanSetUsingFunctionCall() {
        $assoc = new AssocArr();

        $assoc->name('nathan');

        $this->assertEquals(
            $assoc['name'],
            'nathan'
        );
    }

    public function testCanGetUsingArrayAccess() {
        $assoc = new AssocArr();

        $assoc['name'] = 'nathan';

        $this->assertEquals(
            $assoc['name'],
            'nathan'
        );
    }

    public function testCanGetUsingClassProperties() {
        $assoc = new AssocArr();

        $assoc['name'] = 'nathan';

        $this->assertEquals(
            $assoc->name,
            'nathan'
        );
    }

    public function testCanGetUsingFunctionCall() {
        $assoc = new AssocArr();

        $assoc['name'] = 'nathan';

        $this->assertEquals(
            $assoc->name(),
            'nathan'
        );
    }

    public function testGetArrayReturnedAsAssociativeArray() {
        $assoc = new AssocArr([
            'test' => [
                'name'
            ]
        ]);

        $this->assertInstanceOf(AssocArr::class, $assoc->test);
    }

    public function testCallArrayReturnedAsAssociativeArray() {
        $assoc = new AssocArr([
            'test' => [
                'name'
            ]
        ]);

        $this->assertInstanceOf(AssocArr::class, $assoc->test());
    }

    public function testFunctionCallOnNonExistantPropertyResultsInException() {
        $assoc = new AssocArr();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Call to undefined function \'test\'.');

        $something = $assoc->test();
    }

    public function testCallToNonExistantPropertyResultsInException() {
        $assoc = new AssocArr();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Undefined property \'test\'.');

        $something = $assoc->test;
    }

    public function testOffsetSetOnNullOffset() {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Must supply key to modify arguments in an AssociativeArray.');

        $arr = new AssocArr();
        $arr->offsetSet(null, 'value');
    }

}
