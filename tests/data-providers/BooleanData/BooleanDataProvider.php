<?php

declare(strict_types=1);

namespace Quillstack\UnitTests\Tests\DataProviders\BooleanData;

use Quillstack\UnitTests\DataProviderInterface;

class BooleanDataProvider implements DataProviderInterface
{
    public function provides(): array
    {
        return [
            [true],
            [false],
        ];
    }
}
