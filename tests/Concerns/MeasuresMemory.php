<?php

namespace Upstash\Vector\Tests\Concerns;

trait MeasuresMemory
{
    private function measureMemory(callable $callback): int
    {
        $start = memory_get_usage();
        $callback();
        $end = memory_get_usage();

        return $end - $start;
    }
}
