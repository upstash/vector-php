<?php

namespace Upstash\Vector;

use Upstash\Vector\Contracts\Arrayable;

final readonly class DenseIndexInfo implements Arrayable
{
    public function __construct(
        public int $dimension = 0,
        public string $similarityFunction = '',
        public string $embeddingModel = '',
    ) {}

    public function toArray(): array
    {
        return [
            'dimension' => $this->dimension,
            'similarityFunction' => $this->similarityFunction,
            'embeddingModel' => $this->embeddingModel,
        ];
    }
}
