<?php

declare(strict_types=1);

namespace Quillstack\UnitTests\Tests\DataProviders;

use Quillstack\UnitTests\DataProviderInterface;

class EmptyDataProvider implements DataProviderInterface
{
    public function provides(): array
    {
        return [
            [[]],
            [''],
            [0],
            [""],
            [null],
            [false],
            ['0'],
        ];
    }
}