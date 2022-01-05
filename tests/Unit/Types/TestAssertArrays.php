<?php

declare(strict_types=1);

namespace Quillstack\UnitTests\Tests\Unit\Types;

use Quillstack\UnitTests\AssertExceptions;
use Quillstack\UnitTests\Attributes\ProvidesDataFrom;
use Quillstack\UnitTests\Exceptions\Types\Arrays\ArrayCountNotMatchException;
use Quillstack\UnitTests\Exceptions\Types\Arrays\ArrayDoesntHaveKeyException;
use Quillstack\UnitTests\Exceptions\Types\Arrays\ArrayHasKeyException;
use Quillstack\UnitTests\Tests\DataProviders\ArrayData\ArrayKeysDataProvider;
use Quillstack\UnitTests\Tests\DataProviders\ArrayData\ArrayMissingKeysDataProvider;
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

    #[ProvidesDataFrom(ArrayKeysDataProvider::class)]
    public function hasKey(int|string $key, array $array)
    {
        $this->assertArray->hasKey($key, $array);
    }

    #[ProvidesDataFrom(ArrayMissingKeysDataProvider::class)]
    public function hasKeyException(int|string $key, array $array)
    {
        $this->assertExceptions->expect(ArrayDoesntHaveKeyException::class);

        $this->assertArray->hasKey($key, $array);
    }

    #[ProvidesDataFrom(ArrayMissingKeysDataProvider::class)]
    public function doesntHaveKey(int|string $key, array $array)
    {
        $this->assertArray->doesntHaveKey($key, $array);
    }

    #[ProvidesDataFrom(ArrayKeysDataProvider::class)]
    public function doesntHaveKeyException(int|string $key, array $array)
    {
        $this->assertExceptions->expect(ArrayHasKeyException::class);

        $this->assertArray->doesntHaveKey($key, $array);
    }
}
