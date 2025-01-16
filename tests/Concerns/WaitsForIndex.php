<?php

namespace Upstash\Vector\Tests\Concerns;

use Upstash\Vector\Contracts\IndexNamespaceInterface;

trait WaitsForIndex
{
    private function waitForIndex(IndexNamespaceInterface $namespace): void
    {
        $info = $namespace->getNamespaceInfo();

        while ($info->pendingVectorCount > 0) {
            usleep(400_000); // 0.4 seconds
            $info = $namespace->getNamespaceInfo();
        }
    }
}
