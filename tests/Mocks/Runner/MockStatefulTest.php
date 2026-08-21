<?php

declare(strict_types=1);

namespace Quillstack\UnitTests\Tests\Mocks\Runner;

use Quillstack\UnitTests\Exceptions\Types\Booleans\ValueIsNotTrueException;

/**
 * Every test has to start from the state the constructor left, so the second method must
 * not see what the first one wrote.
 */
class MockStatefulTest
{
    public array $seen = [];

    public function first(): void
    {
        $this->seen[] = 'first';
    }

    public function second(): void
    {
        $this->seen[] = 'second';

        if (count($this->seen) !== 1) {
            throw new ValueIsNotTrueException('state leaked between tests');
        }
    }
}
