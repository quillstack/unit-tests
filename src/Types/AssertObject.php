<?php

namespace Quillstack\UnitTests\Types;

use Quillstack\UnitTests\Exceptions\Types\Objects\ObjectIsNotInstanceOfClassException;

class AssertObject
{
    public function instanceOf(string $instance, object $object)
    {
        if ($object instanceof $instance) {
            return;
        }

        throw new ObjectIsNotInstanceOfClassException("Expected object of {$instance}");
    }
}
