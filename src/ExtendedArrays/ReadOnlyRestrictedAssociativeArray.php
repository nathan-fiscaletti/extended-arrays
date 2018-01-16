<?php

namespace ExtendedArrays;

use ExtendedArrays\Traits\ReadOnly;
use ExtendedArrays\RestrictedAssociativeArray as ResAssocArray;

class ReadOnlyRestrictedAssociativeArray extends ResAssocArray
{
    use ReadOnly;
}
