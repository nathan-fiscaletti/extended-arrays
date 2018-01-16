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
}