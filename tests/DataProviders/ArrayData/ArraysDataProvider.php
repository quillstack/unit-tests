<?php

declare(strict_types=1);

namespace Quillstack\UnitTests\Tests\DataProviders\ArrayData;

use Quillstack\UnitTests\DataProviderInterface;

class ArraysDataProvider implements DataProviderInterface
{
    public function provides(): array
    {
        return [
            [[]],
            [[1]],
            [[null]],
            [[1, 2, 3]],
            [['1', '2', '3']],
            [['one' => 1, 'two' => '2', 'three' => null, 'four' => true]],
            [[-1, 'true', 3.14]],
        ];
    }
}
