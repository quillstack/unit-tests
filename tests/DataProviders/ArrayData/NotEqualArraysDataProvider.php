<?php

declare(strict_types=1);

namespace Quillstack\UnitTests\Tests\DataProviders\ArrayData;

use Quillstack\UnitTests\DataProviderInterface;

class NotEqualArraysDataProvider implements DataProviderInterface
{
    public function provides(): array
    {
        return [
            [[], [0]],
            [[1], [2]],
            [[null], [false]],
            [[1, 2, 3], [1, 2]],
            [['1', '2', '3'], [1, '2', '3']],
            [['one' => 1, 'two' => '2', 'three' => null, 'four' => true], ['two' => '2', 'three' => null]],
            [[-1, 'true', 3.14], [-1, true, 3.14]],
        ];
    }
}
