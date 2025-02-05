<?php

namespace Upstash\Vector;

use Upstash\Vector\Contracts\Arrayable;

final readonly class NamespaceInfo implements Arrayable
{
    public function __construct(
        public int $vectorCount = 0,
        public int $pendingVectorCount = 0,
    ) {}

    /**
     * @return array{
     *     vectorCount: int,
     *     pendingVectorCount: int
     * }
     */
    public function toArray(): array
    {
        return [
            'vectorCount' => $this->vectorCount,
            'pendingVectorCount' => $this->pendingVectorCount,
        ];
    }
}
