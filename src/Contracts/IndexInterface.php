<?php

namespace Upstash\Vector\Contracts;

use Upstash\Vector\IndexInfo;

interface IndexInterface extends IndexNamespaceInterface
{
    public function namespace(string $namespace): IndexNamespaceInterface;

    public function getInfo(): IndexInfo;

    public function resetAll(): void;
}
