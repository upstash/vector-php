<?php

namespace Upstash\Vector;

final readonly class DataUpsert
{
    public function __construct(
        public string $id,
        public string $data,
        public array $metadata = [],
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'data' => $this->data,
            'metadata' => (object) $this->metadata,
        ];
    }
}
