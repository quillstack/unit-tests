<?php

declare(strict_types=1);

namespace Quillstack\UnitTests\Tests\DataProviders\ArrayData;

use Quillstack\UnitTests\DataProviderInterface;

class NotArraysDataProvider implements DataProviderInterface
{
    public function provides(): array
    {
        return [
            [1],
            [false],
            [null],
            [true],
            [3.14],
            ['text'],
            [-145],
            [-2.16],
            [new \stdClass()],
        ];
    }
}
