<?php

namespace ExtendedArrays;

use ExtendedArrays\Traits\ReadOnly;
use ExtendedArrays\AssociativeArray as AssocArray;

class ReadOnlyAssociativeArray extends AssocArray
{
    use ReadOnly;
}
