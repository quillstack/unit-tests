<?php

declare(strict_types=1);

namespace Quillstack\UnitTests\Tests\DataProviders\StringData;

use Quillstack\UnitTests\DataProviderInterface;

class NotStringsDataProvider implements DataProviderInterface
{
    public function provides(): array
    {
        return [
            [0],
            [null],
            [1],
            [-1],
            [[]],
            [[1, 2]],
            [false],
            [true],
            [3.14],
        ];
    }
}
