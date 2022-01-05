<?php

declare(strict_types=1);

namespace Quillstack\UnitTests\Tests\DataProviders\ArrayData;

use Quillstack\UnitTests\DataProviderInterface;

class ArrayMissingKeysDataProvider implements DataProviderInterface
{
    public function provides(): array
    {
        return [
            ['c', ['a' => 'b', 'test' => 'value']],
            ['value', ['a' => 'b', 'test' => 'value']],
        ];
    }
}