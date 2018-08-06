<?php

namespace ExtendedArrays\Tests;

use ExtendedArrays\Traits\Restricted;
use ExtendedArrays\AssociativeArray as AssocArr;

use PHPUnit\Framework\TestCase;

/**
 * @covers \ExtendedArrays\Traits\Restricted
 */
final class RestrictedTraitTest extends TestCase {
    public function testRestrictedTraitAppliedOnlyToAssociativeArrayClass() {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Cannot apply \'Restricted\' trait to a class that does not inherit \\ExtendedArrays\\AssociativeArray');

        $obj = new class {
            use Restricted;
        };
    }

    public function testRestrictedTraitInheritsFillableProperty() {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Cannot apply \'Restricted\' trait to a class that does not inherit the \'$fillable\' class property.');

        $obj = new class extends AssocArr {
            use Restricted;
        };
    }

    public function testCallArrayReturnedAsAssociativeArray()
    {
        $obj = new class extends AssocArr {
            use Restricted;

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

        $this->assertInstanceOf(AssocArr::class, $obj->test());
    }

    public function testCallArrayOnUndefinedFunctionThrowsException()
    {
        $obj = new class extends AssocArr {
            use Restricted;

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
        $this->expectExceptionMessage('Call to undefined function \'undefinedFunction\'.');

        $obj->undefinedFunction();
    }

    public function testGetArrayReturnedAsAssociativeArray()
    {
        $obj = new class extends AssocArr {
            use Restricted;

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

        $this->assertInstanceOf(AssocArr::class, $obj->test);
    }

    public function testGetArrayOnInvalidPropertyThrowsException()
    {
        $obj = new class extends AssocArr {
            use Restricted;

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
        $this->expectExceptionMessage('Undefined property \'invalidProperty\'.');

        $obj->invalidProperty;
    }

    public function testGetArrayOnKeyString()
    {
        $obj = new class extends AssocArr {
            use Restricted;

            protected $fillable = ['test'];

            function __construct()
            {
                parent::__construct([
                    'test' => 'test',
                ]);
            }
        };

        $this->assertSame('test', $obj->test);
    }

    public function testSetArrayOnKeyString()
    {
        $obj = new class extends AssocArr {
            use Restricted;

            protected $fillable = ['test'];

            function __construct()
            {
                parent::__construct([
                    'test' => 'test',
                ]);
            }
        };
        $obj->test = 'set_value';

        $this->assertSame('set_value', $obj->test);
    }

    public function testSetArrayThrowsExceptionOnKeyString()
    {
        $obj = new class extends AssocArr {
            use Restricted;

            protected $fillable = ['test'];

            function __construct()
            {
                parent::__construct([
                    'test' => 'test',
                ]);
            }
        };

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Undefined property \'test2\'.');

        $obj->test2 = 'set_value';
    }

    public function testOffsetGetOnOffset()
    {
        $obj = new class extends AssocArr {
            use Restricted;

            protected $fillable = ['test'];

            function __construct()
            {
                parent::__construct([
                    'test' => 'test',
                ]);
            }
        };

        $this->assertSame('test', $obj->offsetGet('test'));
    }

    public function testOffsetGetOnOffsetShouldReturnAssociativeArray()
    {
        $obj = new class extends AssocArr {
            use Restricted;

            protected $fillable = ['test'];

            function __construct()
            {
                parent::__construct([
                    'test' => [
                        'test'
                    ],
                ]);
            }
        };

        $this->assertInstanceOf(AssocArr::class, $obj->offsetGet('test'));
    }

    public function testOffsetGetOnNonExistedOffset()
    {
        $obj = new class extends AssocArr {
            use Restricted;

            protected $fillable = ['test'];

            function __construct()
            {
                parent::__construct([
                    'test' => 'test',
                ]);
            }
        };

        $this->assertNull($obj->offsetGet('non_existed_offset'));
    }

    public function testOffsetUnsetShouldThrowException()
    {
        $obj = new class extends AssocArr {
            use Restricted;

            protected $fillable = ['test'];

            function __construct()
            {
                parent::__construct([
                    'test' => 'test',
                ]);
            }
        };

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Unset not supported in a class using the Restricted trait.');

        $obj->offsetUnset('test');
    }

    public function testOffsetExists()
    {
        $obj = new class extends AssocArr {
            use Restricted;

            protected $fillable = ['test'];

            function __construct()
            {
                parent::__construct([
                    'test' => 'test',
                ]);
            }
        };

        $this->assertTrue($obj->offsetExists('test'));
        $this->assertFalse($obj->offsetExists('invalid_offset'));
    }

    public function testOffsetSetOnNotFillableShouldReturnException()
    {
        $obj = new class extends AssocArr {
            use Restricted;

            protected $fillable = ['test'];

            function __construct()
            {
                parent::__construct([
                    'test' => 'test',
                ]);
            }
        };

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Cannot modify element \'test2\'. Not fillable.');

        $obj->offsetSet('test2', 'value');
    }

    public function testOffsetSetOnNullOffsetShouldReturnException()
    {
        $obj = new class extends AssocArr {
            use Restricted;

            protected $fillable = ['test'];

            function __construct()
            {
                parent::__construct([
                    'test' => 'test',
                ]);
            }
        };

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Must supply key to modify an associative array.');

        $obj->offsetSet(null, 'value');
    }

    public function testOffsetSetOnOffset()
    {
        $obj = new class extends AssocArr {
            use Restricted;

            protected $fillable = ['test'];

            function __construct()
            {
                parent::__construct([
                    'test' => 'test',
                ]);
            }
        };

        $obj->offsetSet('test', 'value');

        $this->assertSame('value', $obj->offsetGet('test'));
    }
}
