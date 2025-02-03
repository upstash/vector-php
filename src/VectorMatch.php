<?php

namespace Upstash\Vector;

use Upstash\Vector\Contracts\VectorIdentifierInterface;

final readonly class VectorMatch implements VectorIdentifierInterface
{
    public function __construct(
        public string $id,
        public float $score,
        public array $vector = [],
        public SparseVector $sparseVector = new SparseVector,
        public string $data = '',
        public array $metadata = [],
    ) {}

    public function getIdentifier(): string
    {
        return $this->id;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'score' => $this->score,
            'vector' => $this->vector,
            'sparseVector' => $this->sparseVector->toArray(),
            'data' => $this->data,
            'metadata' => $this->metadata,
        ];
    }
}
