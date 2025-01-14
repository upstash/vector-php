<?php

namespace Upstash\Vector;

final readonly class NamespaceInfo
{
    public function __construct(
        public int $vectorCount = 0,
        public int $pendingVectorCount = 0,
    ) {}
}
