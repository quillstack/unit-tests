<?php

namespace Quillstack\UnitTests;

class AssertExceptions
{
    public function expect(string $exception): void
    {
        ExceptionExpectation::set($exception);
    }
}
