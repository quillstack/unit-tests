<?php

namespace Quillstack\UnitTests;

class AssertException
{
    public function expect(string $exception): void
    {
        ExceptionExpectation::set($exception);
    }
}
