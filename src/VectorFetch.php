<?php

namespace Upstash\Vector;

use Upstash\Vector\Contracts\Arrayable;

final readonly class VectorFetch implements Arrayable
{
    /**
     * @param  array<string>  $ids
     */
    public function __construct(
        public array $ids,
        public bool $includeMetadata = false,
        public bool $includeVectors = false,
        public bool $includeData = false,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'ids' => $this->ids,
            'includeMetadata' => $this->includeMetadata,
            'includeVectors' => $this->includeVectors,
            'includeData' => $this->includeData,
        ];
    }
}
