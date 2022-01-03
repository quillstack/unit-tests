<?php

declare(strict_types=1);

namespace Quillstack\UnitTests\Tests\DataProviders\NumericData;

use Quillstack\UnitTests\DataProviderInterface;

class IntDataProvider implements DataProviderInterface
{
    public function provides(): array
    {
        return [
            [1],
            [0],
            [-5],
        ];
    }
}
