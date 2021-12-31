<?php

declare(strict_types=1);

namespace Quillstack\UnitTests\Types;

use Quillstack\UnitTests\Exceptions\Types\Objects\ObjectIsNotInstanceOfClassException;
use Quillstack\UnitTests\Exceptions\Types\Objects\ObjectIsNullException;

class AssertObject
{
    public function instanceOf(string $instance, object $object): void
    {
        if ($object instanceof $instance) {
            return;
        }

        throw new ObjectIsNotInstanceOfClassException("Expected object of {$instance}");
    }

    public function notNull(?object $object): void
    {
        if ($object !== null) {
            return;
        }

        throw new ObjectIsNullException();
    }
}
