<?php

declare(strict_types=1);

use Quillstack\UnitTests\Tests\Unit\TestAssertEqual;
use Quillstack\UnitTests\Tests\Unit\TestExceptionExpectation;
use Quillstack\UnitTests\Tests\Unit\Types\TestAssertArrays;
use Quillstack\UnitTests\Tests\Unit\Types\TestAssertBooleans;
use Quillstack\UnitTests\Tests\Unit\Types\TestAssertObjects;

return [
    TestExceptionExpectation::class,
    TestAssertBooleans::class,
    TestAssertArrays::class,
    TestAssertEqual::class,
    TestAssertObjects::class,
];
