<?php

namespace Upstash\Vector\Tests\Concerns;

trait ParatestAware
{
    protected function runningInParatest(): bool
    {
        return getenv('PARATEST') === '1';
    }
}
