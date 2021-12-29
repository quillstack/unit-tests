<?php

declare(strict_types=1);

namespace Quillstack\UnitTests\Tests\DataProviders;

use Quillstack\UnitTests\DataProviderInterface;

class EqualDataProvider implements DataProviderInterface
{
    public function provides(): array
    {
        return [
            [1, 1],
            [2.33, 2.33],
            ['test', 'test'],
            [-55, -55],
            [null, null],
            [[], []],
            [[2, 3, 4], [2, 3, 4]],
            [['test', 1, 'test2'], ['test', 1, 'test2']],
            [['test' => 3.14, '2' => -5], ['test' => 3.14, '2' => -5]],
        ];
    }
}
