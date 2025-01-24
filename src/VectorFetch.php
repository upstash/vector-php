<?php

namespace Upstash\Vector;

final readonly class VectorFetch
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

    public function toArray(): array
    {
        $data = [
            'ids' => $this->ids,
            'includeMetadata' => $this->includeMetadata,
            'includeVectors' => $this->includeVectors,
            'includeData' => $this->includeData,
        ];

        return $data;
    }
}
