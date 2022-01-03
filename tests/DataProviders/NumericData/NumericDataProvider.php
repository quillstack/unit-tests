<?php

declare(strict_types=1);

namespace Quillstack\UnitTests\Tests\DataProviders\NumericData;

use Quillstack\UnitTests\DataProviderInterface;

class NumericDataProvider implements DataProviderInterface
{
    public function provides(): array
    {
        return [
            [0],
            [-1],
            [4],
            [3.14],
            [-5.33],
            [2832183712312412344231],
            [-2832183712312412344231],
            [232e3],
        ];
    }
}
