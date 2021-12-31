<?php

declare(strict_types=1);

namespace Quillstack\UnitTests\Tests\DataProviders\StringData;

use Quillstack\UnitTests\DataProviderInterface;

class NotEqualStringsDataProvider implements DataProviderInterface
{
    public function provides(): array
    {
        return [
            ['test', 'test2'],
            ['', 'null'],
            ['0', '00'],
        ];
    }
}
