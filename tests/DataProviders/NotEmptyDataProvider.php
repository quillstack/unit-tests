<?php

declare(strict_types=1);

namespace Quillstack\UnitTests\Tests\DataProviders;

use Quillstack\UnitTests\DataProviderInterface;

class NotEmptyDataProvider implements DataProviderInterface
{
    public function provides(): array
    {
        return [
            ['string'],
            [['array']],
            [3.14],
            [new \stdClass()],
            [11],
            [-3],
            [-3.14],
        ];
    }
}
