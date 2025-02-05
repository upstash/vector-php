<?php

namespace Upstash\Vector;

use Upstash\Vector\Contracts\Arrayable;
use Upstash\Vector\Contracts\VectorIdentifierInterface;

final readonly class VectorMatch implements Arrayable, VectorIdentifierInterface
{
    /**
     * @param  array<float>  $vector
     * @param  array<string, mixed>  $metadata
     */
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

    /**
     * @return array{
     *     id: string,
     *     score: float,
     *     vector: array<float>,
     *     sparseVector: array{indices: array<int>, values: array<float>},
     *     data: string,
     *     metadata: array<string, mixed>,
     * }
     */
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
