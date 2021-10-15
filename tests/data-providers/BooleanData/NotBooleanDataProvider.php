<?php

declare(strict_types=1);

namespace Quillstack\UnitTests\Tests\DataProviders\BooleanData;

use Quillstack\UnitTests\DataProviderInterface;

class NotBooleanDataProvider implements DataProviderInterface
{
    public function provides(): array
    {
        return [
            [1],
            ['true'],
            ['false'],
            ['string'],
            [3.14],
            ['*'],
            [-55],
            [0],
            [null],
        ];
    }
}
