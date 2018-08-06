<?php

namespace ExtendedArrays\Tests;

use ExtendedArrays\Traits\Sequential;
use ExtendedArrays\AssociativeArray as AssocArr;

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

    public function testSequentialOnAssociativeArrayShouldThrowException() {
        $obj = new class extends AssocArr {
            use Sequential;

            protected $fillable = ['test'];

            function __construct()
            {
                parent::__construct([
                    'test' => [
                        'test'
                    ]
                ]);
            }
        };

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Cannot modify offset \'test\' of IndexedArray.');

        $obj->offsetSet('test', 'value');
    }

    public function testSequentialOnNullOffset() {
        $obj = new class extends AssocArr {
            use Sequential;

            protected $fillable = ['test'];

            function __construct()
            {
                parent::__construct([
                    'test' => [
                        'test'
                    ]
                ]);
            }
        };

        $this->assertNull($obj->offsetSet(null, 'value'));
    }

    public function testSequentialOnNumberOffset() {
        $obj = new class extends AssocArr {
            use Sequential;

            protected $fillable = ['test'];

            function __construct()
            {
                parent::__construct([
                    'test' => [
                        'test'
                    ]
                ]);
            }
        };

        $this->assertNull($obj->offsetSet(0, 'value'));
    }
}
