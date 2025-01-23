<?php

namespace Upstash\Vector\Tests\Concerns;

use Upstash\Vector\Contracts\IndexNamespaceInterface;

trait WaitsForIndex
{
    private function waitForIndex(IndexNamespaceInterface $namespace): void
    {
        usleep(100_000); // 0.1 seconds
        $info = $namespace->getNamespaceInfo();

        while ($info->pendingVectorCount > 0) {
            usleep(300_000); // 0.3 seconds
            $info = $namespace->getNamespaceInfo();
        }
    }
}
