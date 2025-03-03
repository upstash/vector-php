<?php

namespace Upstash\Vector;

use Upstash\Vector\Contracts\Arrayable;

final readonly class VectorRange implements Arrayable
{
    public function __construct(
        public int $limit,
        public string $cursor = '0',
        public ?string $prefix = null,
        public bool $includeMetadata = false,
        public bool $includeVectors = false,
        public bool $includeData = false,
    ) {}

    /**
     * @return array{
     *     limit: int,
     *     cursor: string,
     *     prefix?: string,
     *     includeMetadata: bool,
     *     includeVectors: bool,
     *     includeData: bool,
     * }
     */
    public function toArray(): array
    {
        $data = [
            'limit' => $this->limit,
            'cursor' => $this->cursor,
            'includeMetadata' => $this->includeMetadata,
            'includeVectors' => $this->includeVectors,
            'includeData' => $this->includeData,
        ];

        if ($this->prefix !== null) {
            $data['prefix'] = $this->prefix;
        }

        return $data;
    }
}
