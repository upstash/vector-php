<?php

namespace Upstash\Vector;

final readonly class VectorRange
{
    public function __construct(
        public int $limit,
        public string $cursor = '0',
        public bool $includeMetadata = false,
        public bool $includeVectors = false,
        public bool $includeData = false,
    ) {}

    public function toArray(): array
    {
        return [
            'limit' => $this->limit,
            'cursor' => $this->cursor,
            'includeMetadata' => $this->includeMetadata,
            'includeVectors' => $this->includeVectors,
            'includeData' => $this->includeData,
        ];
    }
}
