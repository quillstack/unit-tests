<?php

declare(strict_types=1);

namespace Quillstack\UnitTests\Tests\Mocks\Runner;

use RuntimeException;
use TypeError;

class MockFailingTest
{
    public function throwsAnException(): void
    {
        throw new RuntimeException('failed on purpose');
    }

    /**
     * An Error is not an Exception, and used to escape the runner completely.
     */
    public function throwsAnError(): void
    {
        throw new TypeError('wrong type on purpose');
    }

    public function passes(): void
    {
        //
    }
}
