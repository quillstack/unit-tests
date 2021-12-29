<?php

declare(strict_types=1);

namespace Quillstack\UnitTests\Tests\Unit\Types;

use Quillstack\UnitTests\AssertExceptions;
use Quillstack\UnitTests\Exceptions\Types\Objects\ObjectIsNotInstanceOfClassException;
use Quillstack\UnitTests\Tests\Mocks\{Example, WrongClass};
use Quillstack\UnitTests\Types\AssertObject;

class TestAssertObjects
{
    public function __construct(private AssertObject $assertObject, private AssertExceptions $assertExceptions)
    {
        //
    }

    public function instance()
    {
        $example = new Example();

        $this->assertObject->instanceOf(Example::class, $example);
    }

    public function instanceException()
    {
        $this->assertExceptions->expect(ObjectIsNotInstanceOfClassException::class);

        $example = new Example();
        $this->assertObject->instanceOf(WrongClass::class, $example);
    }
}
