<?php

namespace Quillstack\UnitTests\Tests\DataProviders\ArrayData;

use Quillstack\UnitTests\DataProviderInterface;

class CountFailureDataProvider implements DataProviderInterface
{
    public function provides(): array
    {
        return [
            [0, []],
            [1, [1]],
            [2, [1, 2]],
            [2, ['test' => 1, 'test2' => 2]],
        ];
    }
}
