<?php

declare(strict_types=1);

namespace Quillstack\UnitTests\Tests\DataProviders\StringData;

use Quillstack\UnitTests\DataProviderInterface;

class EqualStringsDataProvider implements DataProviderInterface
{
    public function provides(): array
    {
        return [
            ['test', 'test'],
            ['', ''],
            ['0', '0'],
        ];
    }
}
