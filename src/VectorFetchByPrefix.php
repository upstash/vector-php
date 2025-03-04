<?php

namespace Upstash\Vector;

use Upstash\Vector\Contracts\Arrayable;

final readonly class VectorFetchByPrefix implements Arrayable
{
    public function __construct(
        public string $prefix,
        public bool $includeMetadata = false,
        public bool $includeVectors = false,
        public bool $includeData = false,
    ) {}

    /**
     * @return array{
     *     prefix: string,
     *     includeMetadata: bool,
     *     includeVectors: bool,
     *     includeData: bool,
     * }
     */
    public function toArray(): array
    {
        return [
            'prefix' => $this->prefix,
            'includeMetadata' => $this->includeMetadata,
            'includeVectors' => $this->includeVectors,
            'includeData' => $this->includeData,
        ];
    }
}
