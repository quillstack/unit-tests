<?php

namespace Quillstack\UnitTests;

use Exception;
use Quillstack\DI\Container;

class UnitTests
{
    private Container $di;

    public function __construct(private array $tests = [])
    {
        $this->di = new Container();
    }

    public function run(): void
    {
        foreach ($this->tests as $test) {
            echo $test, ':', PHP_EOL;
            $testObject = $this->di->get($test);
            $methods = get_class_methods($test);

            foreach ($methods as $method) {
                if (str_starts_with($method, '__')) {
                    continue;
                }

                try {
                    $testObject->$method();
                    echo '.';
                } catch (Exception $exception) {
                    if (ExceptionExpectation::expected(get_class($exception))) {
                        echo '.';
                        ExceptionExpectation::reset();
                        continue;
                    }

                    echo 'E';
                    throw $exception;
                }
            }

            echo PHP_EOL;
        }
    }
}
