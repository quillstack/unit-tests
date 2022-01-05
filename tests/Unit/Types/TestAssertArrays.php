<?php

declare(strict_types=1);

namespace Quillstack\UnitTests\Tests\Unit\Types;

use Quillstack\UnitTests\AssertExceptions;
use Quillstack\UnitTests\Attributes\ProvidesDataFrom;
use Quillstack\UnitTests\Exceptions\Types\Arrays\ArrayCountNotMatchException;
use Quillstack\UnitTests\Exceptions\Types\Arrays\ArrayDoesntHaveKeyException;
use Quillstack\UnitTests\Exceptions\Types\Arrays\ArrayHasKeyException;
use Quillstack\UnitTests\Exceptions\Types\Arrays\ArrayValuesEqualException;
use Quillstack\UnitTests\Exceptions\Types\Arrays\ArrayValuesNotEqualException;
use Quillstack\UnitTests\Exceptions\Types\Arrays\ValueIsNotArrayException;
use Quillstack\UnitTests\Tests\DataProviders\ArrayData\ArrayKeysDataProvider;
use Quillstack\UnitTests\Tests\DataProviders\ArrayData\ArrayMissingKeysDataProvider;
use Quillstack\UnitTests\Tests\DataProviders\ArrayData\ArraysDataProvider;
use Quillstack\UnitTests\Tests\DataProviders\ArrayData\CountFailureDataProvider;
use Quillstack\UnitTests\Tests\DataProviders\ArrayData\NotArraysDataProvider;
use Quillstack\UnitTests\Tests\DataProviders\ArrayData\NotEqualArraysDataProvider;
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

    #[ProvidesDataFrom(ArraysDataProvider::class)]
    public function isArray(array $array)
    {
        $this->assertArray->isArray($array);
    }

    #[ProvidesDataFrom(NotArraysDataProvider::class)]
    public function isArrayException(mixed $value)
    {
        $this->assertExceptions->expect(ValueIsNotArrayException::class);

        $this->assertArray->isArray($value);
    }

    #[ProvidesDataFrom(ArraysDataProvider::class)]
    public function equal(array $a)
    {
        $this->assertArray->equal($a, $a);
    }

    #[ProvidesDataFrom(NotEqualArraysDataProvider::class)]
    public function equalException(array $a, array $b)
    {
        $this->assertExceptions->expect(ArrayValuesNotEqualException::class);

        $this->assertArray->equal($a, $b);
    }

    #[ProvidesDataFrom(NotEqualArraysDataProvider::class)]
    public function notEqual(array $a, array $b)
    {
        $this->assertArray->notEqual($a, $b);
    }

    #[ProvidesDataFrom(ArraysDataProvider::class)]
    public function notEqualException(array $a)
    {
        $this->assertExceptions->expect(ArrayValuesEqualException::class);

        $this->assertArray->notEqual($a, $a);
    }
}
