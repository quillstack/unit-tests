<?php

declare(strict_types=1);

namespace Quillstack\UnitTests\Tests\DataProviders\StringData;

use Quillstack\UnitTests\DataProviderInterface;

class StringsDataProvider implements DataProviderInterface
{
    public function provides(): array
    {
        return [
            [''],
            ['test'],
            ['0'],
            ['-1'],
            ['null'],
            ['false'],
            ['true'],
        ];
    }
}
