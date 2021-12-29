<?php

declare(strict_types=1);

namespace Quillstack\UnitTests\Tests\DataProviders;

use Quillstack\UnitTests\DataProviderInterface;
use RuntimeException;

class ExceptionsDataProvider implements DataProviderInterface
{
    public function provides(): array
    {
        return [
            [RuntimeException::class],
        ];
    }
}
