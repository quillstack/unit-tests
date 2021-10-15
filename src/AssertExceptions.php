<?php

declare(strict_types=1);

namespace Quillstack\UnitTests;

class AssertExceptions
{
    public function expect(string $exception): void
    {
        ExceptionExpectation::set($exception);
    }
}
