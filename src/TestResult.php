<?php

declare(strict_types=1);

namespace Quillstack\UnitTests;

use Throwable;

/**
 * Collects what happened while the tests ran, so a failing test no longer has to stop the
 * whole run to be reported.
 */
class TestResult
{
    private int $passed = 0;

    /**
     * @var array<int, array{test: string, method: string, error: Throwable}>
     */
    private array $failures = [];

    public function pass(): void
    {
        ++$this->passed;
    }

    public function fail(string $test, string $method, Throwable $error): void
    {
        $this->failures[] = [
            'test' => $test,
            'method' => $method,
            'error' => $error,
        ];
    }

    public function getPassed(): int
    {
        return $this->passed;
    }

    /**
     * @return array<int, array{test: string, method: string, error: Throwable}>
     */
    public function getFailures(): array
    {
        return $this->failures;
    }

    public function getTotal(): int
    {
        return $this->passed + count($this->failures);
    }

    public function isSuccessful(): bool
    {
        return $this->failures === [];
    }
}
