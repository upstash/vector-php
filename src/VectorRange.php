<?php

namespace Upstash\Vector;

use Upstash\Vector\Contracts\Arrayable;

final readonly class VectorRange implements Arrayable
{
    public function __construct(
        public int $limit,
        public string $cursor = '0',
        public bool $includeMetadata = false,
        public bool $includeVectors = false,
        public bool $includeData = false,
    ) {}

    /**
     * @return array{
     *     limit: int,
     *     cursor: string,
     *     includeMetadata: bool,
     *     includeVectors: bool,
     *     includeData: bool,
     * }
     */
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
