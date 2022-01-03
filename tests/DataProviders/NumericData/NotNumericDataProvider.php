<?php

declare(strict_types=1);

namespace Quillstack\UnitTests\Tests\DataProviders\NumericData;

use Quillstack\UnitTests\DataProviderInterface;

class NotNumericDataProvider implements DataProviderInterface
{
    public function provides(): array
    {
        return [
            ['test'],
            [null],
            ['Abc'],
            [[1, 2, 3]],
            [new \stdClass()],
        ];
    }
}
