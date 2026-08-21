<?php

declare(strict_types=1);

namespace Quillstack\UnitTests;

interface DataProviderInterface
{
    /**
     * One row per run of the test, each holding the arguments for it.
     *
     * @return array<int, array<int, mixed>>
     */
    public function provides(): array;
}
