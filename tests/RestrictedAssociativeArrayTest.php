<?php

namespace ExtendedArrays\Tests;

use ExtendedArrays\RestrictedAssociativeArray as RestrictedAssocArr;

use PHPUnit\Framework\TestCase;

/**
 * @covers \ExtendedArrays\RestrictedAssociaitiveArray
 */
final class RestrictedAssociativeArrayTest extends TestCase {
    public function testRestrictedAssocArrayRestrictsConstructionWithNonFillableOffset() {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Cannot initialize element \'has_girlfriend\' on an AssociativeArray that uses the Restricted trait. \'has_girlfriend\' is not fillable.');

        $assoc = new class extends RestrictedAssocArr {
            public $fillable = [
                'name',
                'age'
            ];

            public function __construct()
            {
                parent::__construct([
                    'name' => 'nathan',
                    'age' => 22,
                    'has_girlfriend' => true
                ]);
            }
        };
    }

    public function testRestrictedAssocArrayRestrictsArrayAccessSetWithNonFillableOffset() {
        $assoc = new class extends RestrictedAssocArr {
            public $fillable = [
                'name',
                'age'
            ];

            public function __construct()
            {
                parent::__construct([
                    'name' => 'nathan',
                    'age' => 22
                ]);
            }
        };

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Cannot modify element \'test\'. Not fillable.');

        $assoc['test'] = 'name';
    }

    public function testRestrictedAssocArrayRestrictsPropertySetWithNonFillableOffset() {
        $assoc = new class extends RestrictedAssocArr {
            public $fillable = [
                'name',
                'age'
            ];

            public function __construct()
            {
                parent::__construct([
                    'name' => 'nathan',
                    'age' => 22
                ]);
            }
        };

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Undefined property \'test\'');

        $assoc->test = 'name';
    }

    public function testRestrictedAssocArrayRestrictsFunctionSetWithNonFillableOffset() {
        $assoc = new class extends RestrictedAssocArr {
            public $fillable = [
                'name',
                'age'
            ];

            public function __construct()
            {
                parent::__construct([
                    'name' => 'nathan',
                    'age' => 22
                ]);
            }
        };

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Call to undefined function \'test\'');

        $assoc->test('name');
    }

    public function testRestrictedAssocArrayRestrictsUnset() {
        $assoc = new class extends RestrictedAssocArr {
            public $fillable = [
                'name',
                'age'
            ];

            public function __construct()
            {
                parent::__construct([
                    'name' => 'nathan',
                    'age' => 22
                ]);
            }
        };

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Unset not supported in a class using the Restricted trait.');

        unset($assoc['name']);
    }
}