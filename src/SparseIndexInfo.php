<?php

namespace Upstash\Vector;

use Upstash\Vector\Contracts\Arrayable;

final readonly class SparseIndexInfo implements Arrayable
{
    public function __construct(
        public string $embeddingModel = '',
    ) {}

    public function toArray(): array
    {
        return [
            'embeddingModel' => $this->embeddingModel,
        ];
    }
}
