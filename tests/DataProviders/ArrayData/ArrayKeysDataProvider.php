<?php

declare(strict_types=1);

namespace Quillstack\UnitTests\Tests\DataProviders\ArrayData;

use Quillstack\UnitTests\DataProviderInterface;

class ArrayKeysDataProvider implements DataProviderInterface
{
    public function provides(): array
    {
        return [
            ['test', ['a' => 'b', 'test' => 'value']],
            ['a', ['a' => 'b', 'test' => 'value']],
        ];
    }
}
