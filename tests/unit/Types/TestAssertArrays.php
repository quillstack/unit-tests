<?php

declare(strict_types=1);

namespace Quillstack\UnitTests\Tests\Unit\Types;

use Quillstack\UnitTests\AssertExceptions;
use Quillstack\UnitTests\Attributes\ProvidesDataFrom;
use Quillstack\UnitTests\Exceptions\Types\Arrays\ArrayCountNotMatchException;
use Quillstack\UnitTests\Tests\DataProviders\ArrayData\CountFailureDataProvider;
use Quillstack\UnitTests\Types\AssertArray;

class TestAssertArrays
{
    public function __construct(
        private AssertArray $assertArray,
        private AssertExceptions $assertExceptions
    ) {
        //
    }

    #[ProvidesDataFrom(CountFailureDataProvider::class)]
    public function countFailure(int $count, array $array)
    {
        $this->assertExceptions->expect(ArrayCountNotMatchException::class);
        $this->assertArray->count($count + 1, $array);
    }

    #[ProvidesDataFrom(CountFailureDataProvider::class)]
    public function countSuccess(int $count, array $array)
    {
        $this->assertArray->count($count, $array);
    }
}
