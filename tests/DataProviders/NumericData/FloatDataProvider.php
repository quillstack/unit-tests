<?php

declare(strict_types=1);

namespace Quillstack\UnitTests\Tests\DataProviders\NumericData;

use Quillstack\UnitTests\DataProviderInterface;

class FloatDataProvider implements DataProviderInterface
{
    public function provides(): array
    {
        return [
            [-3.14],
            [4.222],
            [1.000001],
        ];
    }
}
