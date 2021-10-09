<?php

namespace Quillstack\UnitTests;

use Exception;
use Quillstack\DI\Container;
use Quillstack\LocalStorage\LocalStorage;
use Quillstack\StorageInterface\StorageInterface;

class UnitTests
{
    private Container $di;

    public function __construct(private array $tests = [])
    {
        $this->di = new Container([
            StorageInterface::class => LocalStorage::class,
        ]);
    }

    public function run(): void
    {
        \phpdbg_start_oplog();

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

        $data = \phpdbg_end_oplog();
        $result = [];
        $output = [];

        foreach ($data as $file => $coverage) {
            if (!str_starts_with($file, __DIR__)) {
                continue;
            }

            foreach ($coverage as $line => $value) {
                $result[$file][$line] = $value <= 0 ? 0 : 1;
            }
        }

        $lines = phpdbg_get_executable();

        foreach ($lines as $file => $coverage) {
            if (!str_starts_with($file, __DIR__)) {
                continue;
            }

            foreach ($coverage as $line => $value) {
                if (isset($result[$file][$line])) {
                    $output[$file][$line] = $result[$file][$line];
                } else {
                    $output[$file][$line] = $value;
                }
            }
        }

        $xml = new \SimpleXMLElement('<xml/>');
        $coverage = $xml->addChild('coverage');
        $project = $coverage->addChild('project');
        foreach ($output as $file => $lines) {
            $class = $project->addChild('file');
            $class->addAttribute('name', $file);
            foreach ($lines as $line => $value) {
                $row = $class->addChild('line');
                $row->addAttribute('num', $line);
                $row->addAttribute('count', $value);
            }
        }

        $storage = $this->di->get(StorageInterface::class);
        $storage->save(__DIR__ . '/../unit-tests.coverage.xml', $xml->asXML());
    }
}
